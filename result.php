<?php
require "config.php";
require "auth.php";
requireLogin();

$resultId = (int)($_GET["id"] ?? 0);

$stmt = $pdo->prepare("
    SELECT r.*, q.title, q.category
    FROM results r
    JOIN quizzes q ON q.quiz_id = r.quiz_id
    WHERE r.result_id = ? AND r.user_id = ?
");
$stmt->execute([$resultId, $_SESSION["user_id"]]);
$result = $stmt->fetch();

if (!$result) {
    die("Result not found.");
}

// Fetch all questions for this quiz so the result page can show a full review.
$stmt = $pdo->prepare("
    SELECT question_id, question_text, option_a, option_b, option_c, option_d, correct_answer
    FROM questions
    WHERE quiz_id = ?
    ORDER BY question_id
");
$stmt->execute([(int)$result["quiz_id"]]);
$questions = $stmt->fetchAll();

// Prefer permanently saved answers. Fall back to the current session for old results.
$savedAnswers = [];
try {
    $stmt = $pdo->prepare("SELECT question_id, selected_answer, correct_answer FROM result_answers WHERE result_id = ?");
    $stmt->execute([$resultId]);
    foreach ($stmt->fetchAll() as $row) {
        $savedAnswers[(int)$row["question_id"]] = strtoupper(trim((string)($row["selected_answer"] ?? "")));
    }
} catch (Throwable $e) {
    // Existing databases may not have result_answers yet; session fallback below handles it.
}

if (!$savedAnswers &&
    isset($_SESSION["last_quiz_answers"], $_SESSION["last_quiz_id"]) &&
    (int)$_SESSION["last_quiz_id"] === (int)$result["quiz_id"]) {
    foreach ($_SESSION["last_quiz_answers"] as $questionId => $answer) {
        $savedAnswers[(int)$questionId] = strtoupper(trim((string)$answer));
    }
}

$percentage = (float)$result["percentage"];
if ($percentage >= 80) {
    $message = "Excellent work!";
} elseif ($percentage >= 50) {
    $message = "Good job! Keep practicing.";
} else {
    $message = "Keep learning and try again!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Quiz Result - QuizMaster</title>
<link rel="stylesheet" href="style.css">
<style>
/* Result summary at the top center; question review below. */
body.result-page {
    display: block !important;
    min-height: 100vh;
    padding: 32px 18px 50px;
}
.result-page .result-card {
    width: min(900px, calc(100% - 36px));
    max-width: 900px;
    margin: 0 auto 28px;
    text-align: center;
    box-sizing: border-box;
}
.result-page .result-card .score {
    margin-top: 22px;
}
.result-review {
    width: min(900px, calc(100% - 36px));
    margin: 0 auto 40px;
}
.review-card {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 20px;
    margin: 18px 0;
    box-shadow: 0 8px 28px rgba(31,41,55,.06);
}
.review-card h3 { margin: 0 0 14px; line-height: 1.5; }
.review-option {
    padding: 11px 14px;
    margin: 8px 0;
    border-radius: 9px;
    border: 1px solid #e2e8f0;
    background: #f8fafc;
}
.review-option.correct {
    background: #dcfce7;
    border-color: #86efac;
    color: #166534;
}
.review-option.wrong {
    background: #fee2e2;
    border-color: #fca5a5;
    color: #991b1b;
}
.review-label { font-weight: 700; margin-left: 8px; }
.review-label.correct { color: #15803d; }
.review-label.wrong { color: #dc2626; }
.not-attempted { color: #64748b; font-weight: 700; margin-top: 12px; }
.correct-answer-note { color: #15803d; font-weight: 700; margin-top: 12px; }
.review-heading { text-align: center; margin: 28px 0 12px; }
</style>
</head>
<body class="result-page">

<div class="result-card">
    <div class="brand">QuizMaster</div>
    <span class="badge"><?= htmlspecialchars($result["category"]) ?></span>
    <h1><?= htmlspecialchars($result["title"]) ?></h1>
    <div class="score"><?= (int)$result["score"] ?><small>/<?= (int)$result["total_questions"] ?></small></div>
    <h2><?= number_format($percentage, 1) ?>%</h2>
    <p><?= htmlspecialchars($message) ?></p>
</div>

<section class="result-review">
    <h2 class="review-heading">Question Review</h2>

    <?php foreach ($questions as $index => $q): ?>
        <?php
        $questionId = (int)$q["question_id"];
        $userAnswer = strtoupper(trim((string)($savedAnswers[$questionId] ?? "")));
        $correctAnswer = strtoupper(trim((string)$q["correct_answer"]));

        $options = [
            "A" => $q["option_a"],
            "B" => $q["option_b"],
            "C" => $q["option_c"],
            "D" => $q["option_d"]
        ];
        ?>

        <div class="review-card">
            <h3><?= $index + 1 ?>. <?= htmlspecialchars($q["question_text"]) ?></h3>

            <?php foreach ($options as $letter => $optionText): ?>
                <?php
                $class = '';
                $label = '';

                if ($letter === $correctAnswer) {
                    $class = 'correct';
                    $label = '✓ Correct Answer';
                }

                if ($letter === $userAnswer && $userAnswer !== $correctAnswer) {
                    $class = 'wrong';
                    $label = '✗ Your Answer';
                }

                if ($letter === $userAnswer && $userAnswer === $correctAnswer) {
                    $class = 'correct';
                    $label = '✓ Your Answer';
                }
                ?>

                <div class="review-option <?= $class ?>">
                    <strong><?= $letter ?>.</strong>
                    <?= htmlspecialchars($optionText) ?>
                    <?php if ($label !== ''): ?>
                        <span class="review-label <?= $class ?>"><?= $label ?></span>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>

            <?php if ($userAnswer === ''): ?>
                <div class="not-attempted">Not Attempted</div>
            <?php elseif ($userAnswer !== $correctAnswer): ?>
                <div class="correct-answer-note">
                    Correct Answer: <?= $correctAnswer ?>. <?= htmlspecialchars($options[$correctAnswer]) ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</section>

<div class="result-actions" style="text-align:center; margin-bottom:40px;">
    <a class="btn primary" href="dashboard.php">Back to Dashboard</a>
    <a class="btn" href="quiz.php?id=<?= (int)$result["quiz_id"] ?>">Try Again</a>
</div>

</body>
</html>
