<?php
require_once "config.php";
session_start();
require 'db.php';

$msg = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $hashedPassword);
        $stmt->fetch();

        if (password_verify($password, $hashedPassword)) {
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $username;
            header("Location: dashboard.php");
            exit;
        } else {
            $msg = "Hatalı şifre!";
        }
    } else {
        $msg = "Kullanıcı bulunamadı!";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Giriş Yap - KadenFlux</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <h2>Giriş Yap</h2>

    <?php if (!empty($msg)) echo "<div class='alert alert-danger'>$msg</div>"; ?>

    <form method="POST">
        <div class="mb-3">
            <label>Kullanıcı Adı</label>
            <input type="text" name="username" class="form-control" required />
        </div>
        <div class="mb-3">
            <label>Şifre</label>
            <input type="password" name="password" class="form-control" required />
        </div>
        <button type="submit" class="btn btn-success">Giriş Yap</button>
        <a href="register.php" class="btn btn-link">Hesabınız yok mu?</a>
    </form>
</body>
</html>
