<?php
require "config.php";
require "auth.php";
requireAdmin();

$studentCount = (int)$pdo->query("SELECT COUNT(*) FROM users WHERE role = 'student'")->fetchColumn();
$adminCount = (int)$pdo->query("SELECT COUNT(*) FROM users WHERE role = 'admin'")->fetchColumn();
$quizCount = (int)$pdo->query("SELECT COUNT(*) FROM quizzes")->fetchColumn();
$resultCount = (int)$pdo->query("SELECT COUNT(*) FROM results")->fetchColumn();

$recent = $pdo->query("SELECT r.result_id, u.username, u.email, q.title, r.score, r.total_questions, r.percentage, r.taken_at FROM results r JOIN users u ON u.user_id=r.user_id JOIN quizzes q ON q.quiz_id=r.quiz_id ORDER BY r.result_id DESC LIMIT 20")->fetchAll();
$students = $pdo->query("SELECT u.user_id,u.username,u.email,u.created_at,COUNT(r.result_id) attempts,COALESCE(AVG(r.percentage),0) avg_percentage FROM users u LEFT JOIN results r ON r.user_id=u.user_id WHERE u.role='student' GROUP BY u.user_id ORDER BY u.user_id DESC LIMIT 20")->fetchAll();
$notice = $_GET['deleted'] ?? '';
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0"><title>Admin Panel - QuizMaster</title><link rel="stylesheet" href="style.css"></head>
<body>
<nav class="navbar"><div class="brand">QuizMaster Admin</div><div class="nav-right"><span><?= htmlspecialchars($_SESSION['username']) ?> (Admin)</span><a class="btn small" href="dashboard.php">Student Dashboard</a><a class="btn small" href="logout.php">Logout</a></div></nav>
<main class="container">
<section class="hero"><div><h1>Admin Control Panel</h1><p>Monitor students, exams, results and quiz activity.</p></div></section>
<?php if ($notice): ?><div class="alert success"><?= htmlspecialchars($notice) ?></div><?php endif; ?>
<div class="grid">
<div class="card"><h3>Students</h3><div class="score"><?= $studentCount ?></div></div>
<div class="card"><h3>Admins</h3><div class="score"><?= $adminCount ?></div></div>
<div class="card"><h3>Quizzes</h3><div class="score"><?= $quizCount ?></div></div>
<div class="card"><h3>Total Attempts</h3><div class="score"><?= $resultCount ?></div></div>
</div>
<div class="result-actions" style="margin:20px 0"><a class="btn primary" href="admin_students.php">All Students</a><a class="btn primary" href="admin_results.php">All Results</a><a class="btn primary" href="admin_quizzes.php">Manage Quizzes</a></div>
<h2>Students</h2><div class="card"><div class="table-wrap"><table><tr><th>ID</th><th>Username</th><th>Email</th><th>Attempts</th><th>Avg %</th><th>Joined</th><th>Action</th></tr><?php foreach($students as $s): ?><tr><td><?= (int)$s['user_id'] ?></td><td><?= htmlspecialchars($s['username']) ?></td><td><?= htmlspecialchars($s['email']) ?></td><td><?= (int)$s['attempts'] ?></td><td><?= number_format((float)$s['avg_percentage'],1) ?>%</td><td><?= htmlspecialchars($s['created_at']) ?></td><td><a class="btn small" href="admin_student.php?id=<?= (int)$s['user_id'] ?>">View</a></td></tr><?php endforeach; ?></table></div></div>
<h2 class="section-title">Latest Attempts</h2><div class="card"><div class="table-wrap"><table><tr><th>Student</th><th>Email</th><th>Quiz</th><th>Score</th><th>%</th><th>Date</th></tr><?php foreach($recent as $r): ?><tr><td><?= htmlspecialchars($r['username']) ?></td><td><?= htmlspecialchars($r['email']) ?></td><td><?= htmlspecialchars($r['title']) ?></td><td><?= (int)$r['score'] ?>/<?= (int)$r['total_questions'] ?></td><td><?= number_format((float)$r['percentage'],1) ?>%</td><td><?= htmlspecialchars($r['taken_at']) ?></td></tr><?php endforeach; ?></table></div></div>
</main></body></html>
