<?php
require "config.php";
require "auth.php";
requireLogin();

$quizzes = $pdo->query("
    SELECT q.quiz_id, q.title, q.description, q.category,
           COUNT(ques.question_id) AS question_count
    FROM quizzes q
    LEFT JOIN questions ques ON q.quiz_id = ques.quiz_id
    GROUP BY q.quiz_id
    ORDER BY q.quiz_id DESC
")->fetchAll();

$stmt = $pdo->prepare("
    SELECT r.*, q.title
    FROM results r
    JOIN quizzes q ON q.quiz_id = r.quiz_id
    WHERE r.user_id = ?
    ORDER BY r.result_id DESC
    LIMIT 5
");
$stmt->execute([$_SESSION["user_id"]]);
$results = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard - QuizMaster</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<nav class="navbar">
    <div class="brand">QuizMaster</div>
    <div class="nav-right">
        <span>Hello, <?= htmlspecialchars($_SESSION["username"]) ?></span>
        <?php if (($_SESSION["role"] ?? "student") === "admin"): ?><a class="btn small" href="admin.php">Admin Panel</a><?php endif; ?>
        <a class="btn small" href="logout.php">Logout</a>
    </div>
</nav>

<main class="container">
    <section class="hero">
        <div>
            <h1>Choose a Quiz</h1>
            <p>Test your knowledge and see your score instantly.</p>
        </div>
    </section>

    <h2>Available Quizzes</h2>
    <div class="grid">
        <?php foreach ($quizzes as $quiz): ?>
            <div class="card quiz-card">
                <span class="badge"><?= htmlspecialchars($quiz["category"]) ?></span>
                <h3><?= htmlspecialchars($quiz["title"]) ?></h3>
                <p><?= htmlspecialchars($quiz["description"]) ?></p>
                <p class="muted"><?= (int)$quiz["question_count"] ?> questions</p>
                <?php if ((int)$quiz["question_count"] > 0): ?>
                    <a class="btn primary" href="quiz.php?id=<?= (int)$quiz["quiz_id"] ?>">Start Quiz</a>
                <?php else: ?>
                    <button class="btn disabled" disabled>No questions yet</button>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if (!$quizzes): ?>
        <div class="card center">No quizzes have been added yet.</div>
    <?php endif; ?>

    <h2 class="section-title">Recent Results</h2>
    <div class="card">
        <?php if ($results): ?>
            <div class="table-wrap">
            <table>
                <tr><th>Quiz</th><th>Score</th><th>Total</th><th>Percentage</th></tr>
                <?php foreach ($results as $r): ?>
                <tr>
                    <td><?= htmlspecialchars($r["title"]) ?></td>
                    <td><?= (int)$r["score"] ?></td>
                    <td><?= (int)$r["total_questions"] ?></td>
                    <td><?= number_format((float)$r["percentage"], 1) ?>%</td>
                </tr>
                <?php endforeach; ?>
            </table>
            </div>
        <?php else: ?>
            <p class="muted">You have not completed a quiz yet.</p>
        <?php endif; ?>
    </div>
</main>
</body>
</html>
