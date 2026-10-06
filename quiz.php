<?php
require "config.php";
require "auth.php";
requireLogin();

$quizId = (int)($_GET["id"] ?? $_POST["quiz_id"] ?? 0);

$stmt = $pdo->prepare("SELECT * FROM quizzes WHERE quiz_id = ?");
$stmt->execute([$quizId]);
$quiz = $stmt->fetch();

if (!$quiz) {
    die("Quiz not found.");
}

// Include correct answers because the server calculates the score.
$stmt = $pdo->prepare("SELECT question_id, question_text, option_a, option_b, option_c, option_d, correct_answer FROM questions WHERE quiz_id = ? ORDER BY question_id");
$stmt->execute([$quizId]);
$questions = $stmt->fetchAll();

if (!$questions) {
    die("This quiz has no questions.");
}

// Total quiz time: exactly 2 minutes for the whole quiz.
$timeLimitSeconds = 120;

// Keep the active quiz timer/session across normal page refreshes.
if (!isset($_SESSION["quiz_started_at"], $_SESSION["quiz_timer_id"]) ||
    (int)$_SESSION["quiz_timer_id"] !== $quizId) {
    $_SESSION["quiz_started_at"] = time();
    $_SESSION["quiz_timer_id"] = $quizId;
    $_SESSION["quiz_switch_count"] = 0;
}

if (!isset($_SESSION["quiz_switch_count"])) {
    $_SESSION["quiz_switch_count"] = 0;
}

$startedAt = (int)$_SESSION["quiz_started_at"];
$elapsed = max(0, time() - $startedAt);
$remainingSeconds = max(0, $timeLimitSeconds - $elapsed);

// -----------------------------------------------------------------------------
// SUBMIT QUIZ: calculate, save answers, save result, redirect immediately.
// -----------------------------------------------------------------------------
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $answers = $_POST["answer"] ?? [];
    if (!is_array($answers)) {
        $answers = [];
    }

    // Make sure a repeated POST cannot create duplicate results.
    if (!empty($_SESSION["quiz_submitted"]) &&
        (int)($_SESSION["quiz_submitted_quiz_id"] ?? 0) === $quizId) {
        $existingResultId = (int)($_SESSION["quiz_submitted_result_id"] ?? 0);
        if ($existingResultId > 0) {
            header("Location: result.php?id=" . $existingResultId);
            exit;
        }
    }

    $score = 0;
    $total = count($questions);
    $normalisedAnswers = [];

    foreach ($questions as $q) {
        $questionId = (int)$q["question_id"];
        $userAnswer = strtoupper(trim((string)($answers[$questionId] ?? "")));
        $correctAnswer = strtoupper(trim((string)$q["correct_answer"]));

        // Only A-D are valid submitted options.
        if (!in_array($userAnswer, ["A", "B", "C", "D"], true)) {
            $userAnswer = "";
        }

        $normalisedAnswers[$questionId] = $userAnswer;

        if ($userAnswer !== "" && $userAnswer === $correctAnswer) {
            $score++;
        }
    }

    $percentage = $total > 0 ? round(($score / $total) * 100, 2) : 0;

    // Save the result first. Do not make quiz submission depend on the optional
    // result_answers table: an existing MySQL installation may reject its foreign
    // keys, which would otherwise prevent the score from being saved.
    try {
        $insert = $pdo->prepare("INSERT INTO results (user_id, quiz_id, score, total_questions, percentage) VALUES (?, ?, ?, ?, ?)");
        $insert->execute([
            $_SESSION["user_id"],
            $quizId,
            $score,
            $total,
            $percentage
        ]);

        $resultId = (int)$pdo->lastInsertId();
    } catch (Throwable $e) {
        die("Unable to save quiz result. Please check that the results table exists and try again.");
    }

    // Save question-level answers when the optional table is available.
    // Failure here must NOT cancel the already-saved result.
    try {
        $pdo->exec("CREATE TABLE IF NOT EXISTS result_answers (
            answer_id INT AUTO_INCREMENT PRIMARY KEY,
            result_id INT NOT NULL,
            question_id INT NOT NULL,
            selected_answer CHAR(1) NULL,
            correct_answer CHAR(1) NOT NULL,
            UNIQUE KEY uq_result_question (result_id, question_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $answerInsert = $pdo->prepare("INSERT INTO result_answers (result_id, question_id, selected_answer, correct_answer) VALUES (?, ?, ?, ?)");
        foreach ($questions as $q) {
            $questionId = (int)$q["question_id"];
            $answerInsert->execute([
                $resultId,
                $questionId,
                $normalisedAnswers[$questionId] !== "" ? $normalisedAnswers[$questionId] : null,
                strtoupper(trim((string)$q["correct_answer"]))
            ]);
        }
    } catch (Throwable $e) {
        // The session copy below is enough for immediate result review.
        // Never block the result page because this optional table cannot be created.
    }

    // Keep a session copy too, so the review works even if the answer table
    // cannot be queried for any reason during the same request.
    $_SESSION["last_quiz_answers"] = $normalisedAnswers;
    $_SESSION["last_quiz_id"] = $quizId;
    $_SESSION["quiz_submitted"] = true;
    $_SESSION["quiz_submitted_quiz_id"] = $quizId;
    $_SESSION["quiz_submitted_result_id"] = $resultId;

    // Stop the current timer/anti-cheat session.
    unset(
        $_SESSION["quiz_started_at"],
        $_SESSION["quiz_timer_id"],
        $_SESSION["quiz_switch_count"]
    );

    header("Location: result.php?id=" . $resultId);
    exit;
}

// A new attempt gets a fresh timer after the previous result has been viewed.
if (isset($_SESSION["quiz_submitted_quiz_id"]) &&
    (int)$_SESSION["quiz_submitted_quiz_id"] === $quizId) {
    unset(
        $_SESSION["quiz_submitted"],
        $_SESSION["quiz_submitted_quiz_id"],
        $_SESSION["quiz_submitted_result_id"],
        $_SESSION["quiz_started_at"],
        $_SESSION["quiz_timer_id"],
        $_SESSION["quiz_switch_count"]
    );
    $_SESSION["quiz_started_at"] = time();
    $_SESSION["quiz_timer_id"] = $quizId;
    $_SESSION["quiz_switch_count"] = 0;
    $remainingSeconds = $timeLimitSeconds;
}

// Server-side tab-switch handling.
$switchAction = $_GET["action"] ?? "";
if ($switchAction === "switch") {
    $_SESSION["quiz_switch_count"]++;

    if ((int)$_SESSION["quiz_switch_count"] >= 2) {
        $total = count($questions);
        $insert = $pdo->prepare("INSERT INTO results (user_id, quiz_id, score, total_questions, percentage) VALUES (?, ?, 0, ?, 0)");
        $insert->execute([$_SESSION["user_id"], $quizId, $total]);
        $resultId = (int)$pdo->lastInsertId();

        unset($_SESSION["quiz_started_at"], $_SESSION["quiz_timer_id"], $_SESSION["quiz_switch_count"]);
        header("Location: dashboard.php?quiz_left=1&reason=switch");
        exit;
    }

    $showSwitchWarning = true;
} else {
    $showSwitchWarning = false;
}

// Quit flow.
$showQuitConfirmation = ($switchAction === "confirm_quit");
$quitRequested = ($switchAction === "quit");

if ($quitRequested) {
    $total = count($questions);
    $insert = $pdo->prepare("INSERT INTO results (user_id, quiz_id, score, total_questions, percentage) VALUES (?, ?, 0, ?, 0)");
    $insert->execute([$_SESSION["user_id"], $quizId, $total]);

    unset($_SESSION["quiz_started_at"], $_SESSION["quiz_timer_id"], $_SESSION["quiz_switch_count"]);
    header("Location: dashboard.php?quiz_left=1&reason=quit");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($quiz["title"]) ?> - QuizMaster</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<nav class="navbar">
    <div class="brand">QuizMaster</div>
    <a class="btn small" href="dashboard.php">← Dashboard</a>
</nav>

<main class="container narrow">
    <div class="quiz-header card">
        <span class="badge"><?= htmlspecialchars($quiz["category"]) ?></span>
        <h1><?= htmlspecialchars($quiz["title"]) ?></h1>
        <p><?= htmlspecialchars($quiz["description"]) ?></p>
        <div id="quizTimer" class="quiz-timer" aria-live="polite">Time Left: --:--</div>
    </div>

    <?php if ($showSwitchWarning): ?>
        <div class="quit-box" role="alert">
            <h2>⚠️ Warning: Do not leave the quiz</h2>
            <p>This is your <strong>first page/tab switch warning</strong>. If you switch away again, the quiz will be terminated and recorded as <strong>0 marks</strong>.</p>
            <div class="quit-actions">
                <a href="quiz.php?id=<?= (int)$quizId ?>" class="btn primary">OK, Continue Quiz</a>
            </div>
        </div>
    <?php elseif ($showQuitConfirmation): ?>
        <div class="quit-box" role="alert">
            <h2>⚠️ Are you sure you want to leave this quiz?</h2>
            <p>If you leave this quiz, this attempt will be <strong>recorded as 0 marks (0%)</strong> and it will affect your profile/quiz history.</p>
            <p>Your current progress will be lost.</p>
            <div class="quit-actions">
                <a href="quiz.php?id=<?= (int)$quizId ?>" class="btn primary">Stay in Quiz</a>
                <a href="quiz.php?id=<?= (int)$quizId ?>&action=quit" class="btn">Leave Quiz — 0 Marks</a>
            </div>
        </div>
    <?php else: ?>
    <form method="post" id="quizForm">
        <input type="hidden" name="quiz_id" value="<?= $quizId ?>">

        <?php foreach ($questions as $index => $q): ?>
        <div class="card question-card">
            <h3><?= ($index + 1) ?>. <?= htmlspecialchars($q["question_text"]) ?></h3>

            <?php
            $options = [
                "A" => $q["option_a"],
                "B" => $q["option_b"],
                "C" => $q["option_c"],
                "D" => $q["option_d"]
            ];
            foreach ($options as $letter => $text):
            ?>
                <label class="option">
                    <input type="radio"
                           name="answer[<?= (int)$q["question_id"] ?>]"
                           value="<?= $letter ?>">
                    <span><strong><?= $letter ?>.</strong> <?= htmlspecialchars($text) ?></span>
                </label>
            <?php endforeach; ?>
        </div>
        <?php endforeach; ?>

        <div class="quiz-actions">
            <a class="btn quit-trigger" href="quiz.php?id=<?= (int)$quizId ?>&action=confirm_quit">Quit Quiz</a>
            <button class="btn primary" id="submitQuiz" type="submit">Submit Quiz</button>
        </div>
    </form>
    <?php endif; ?>
</main>

<script>
(function () {
    const form = document.getElementById('quizForm');
    const timer = document.getElementById('quizTimer');
    const submitButton = document.getElementById('submitQuiz');
    let remaining = <?= (int)$remainingSeconds ?>;
    let submitted = false;
    let switchHandling = false;

    function formatTime(seconds) {
        const minutes = Math.floor(seconds / 60);
        const secs = seconds % 60;
        return String(minutes).padStart(2, '0') + ':' + String(secs).padStart(2, '0');
    }

    function updateTimer() {
        if (!timer) return;
        timer.textContent = 'Time Left: ' + formatTime(Math.max(0, remaining));
        if (remaining <= 30) timer.classList.add('danger');
    }

    function autoSubmit() {
        if (submitted || !form) return;
        submitted = true;
        clearInterval(timerInterval);
        if (submitButton) submitButton.disabled = true;
        // form.submit() intentionally bypasses radio-button required validation,
        // so unanswered questions are submitted as blank/wrong.
        HTMLFormElement.prototype.submit.call(form);
    }

    updateTimer();
    const timerInterval = setInterval(function () {
        remaining--;
        updateTimer();
        if (remaining <= 0) {
            clearInterval(timerInterval);
            autoSubmit();
        }
    }, 1000);

    document.addEventListener('visibilitychange', function () {
        if (submitted || switchHandling || !document.hidden || !form) return;
        switchHandling = true;
        window.location.href = 'quiz.php?id=<?= (int)$quizId ?>&action=switch';
    });

    if (form && submitButton) {
        form.addEventListener('submit', function () {
            submitted = true;
            clearInterval(timerInterval);
            submitButton.disabled = true;
        });
    }
})();
</script>
</body>
</html>
