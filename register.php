<?php
require "config.php";
session_start();

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($username === "" || $email === "" || $password === "") {
        $error = "Please fill in all fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email.";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters.";
    } else {
        $check = $pdo->prepare("SELECT user_id FROM users WHERE username = ? OR email = ?");
        $check->execute([$username, $email]);

        if ($check->fetch()) {
            $error = "Username or email already exists.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$username, $email, $hash]);

            header("Location: login.php?registered=1");
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Create Account - QuizMaster</title>
<link rel="stylesheet" href="style.css">
</head>
<body class="auth-page">
<div class="auth-card">
    <div class="brand">QuizMaster</div>
    <h1>Create Account</h1>
    <p class="muted">Join the online quiz platform.</p>

    <?php if ($error): ?><div class="alert error"><?= htmlspecialchars($error) ?></div><?php endif; ?>

    <form method="post">
        <label>Username</label>
        <input type="text" name="username" maxlength="50" required>

        <label>Email</label>
        <input type="email" name="email" maxlength="120" required>

        <label>Password</label>
        <input type="password" name="password" minlength="6" required>

        <button class="btn primary full" type="submit">Create Account</button>
    </form>

    <p class="center">Already have an account? <a href="login.php">Login</a></p>
</div>
</body>
</html>
