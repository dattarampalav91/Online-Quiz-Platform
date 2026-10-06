<?php
require "config.php";
session_start();

$error = "";
$message = isset($_GET["registered"]) ? "Account created. Please login." : "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $login = trim($_POST["login"] ?? "");
    $password = $_POST["password"] ?? "";

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$login, $login]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user["password"])) {
        $_SESSION["user_id"] = $user["user_id"];
        $_SESSION["username"] = $user["username"];
        $_SESSION["role"] = $user["role"] ?? "student";
        if ($_SESSION["role"] === "admin") {
            header("Location: admin.php");
        } else {
            header("Location: dashboard.php");
        }
        exit;
    }

    $error = "Invalid username/email or password.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login - QuizMaster</title>
<link rel="stylesheet" href="style.css">
</head>
<body class="auth-page">
<div class="auth-card">
    <div class="brand">QuizMaster</div>
    <h1>Welcome Back</h1>
    <p class="muted">Login to start a quiz.</p>

    <?php if ($message): ?><div class="alert success"><?= htmlspecialchars($message) ?></div><?php endif; ?>
    <?php if ($error): ?><div class="alert error"><?= htmlspecialchars($error) ?></div><?php endif; ?>

    <form method="post">
        <label>Username or Email</label>
        <input type="text" name="login" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <button class="btn primary full" type="submit">Login</button>
    </form>

    <p class="center">New user? <a href="register.php">Create an account</a></p>
</div>
</body>
</html>
