<?php
require 'config.php';

$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashedPassword);

        try {
            if ($stmt->execute()) {
                $msg = '<div class="alert alert-success">Kayıt başarılı. <a href="login.php">Giriş yapabilirsiniz.</a></div>';
            } else {
                $msg = '<div class="alert alert-danger">Kayıt başarısız. Kullanıcı adı zaten alınmış olabilir.</div>';
            }
        } catch (PDOException $e) {
            $msg = '<div class="alert alert-danger">Hata: ' . $e->getMessage() . '</div>';
        }
    } else {
        $msg = '<div class="alert alert-warning">Kullanıcı adı ve şifre boş olamaz.</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Kayıt Ol - KadenFlux</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background:rgb(180, 208, 235);
        }
        .card {
            border-radius: 1rem;
        }
    </style>
</head>
<body>
    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="col-md-6">
            <div class="card shadow-sm p-4">
                <h2 class="mb-4 text-center">Kayıt Ol</h2>

                <?php echo $msg; ?>

                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="username" class="form-label">Kullanıcı Adı</label>
                        <input type="text" name="username" id="username" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Şifre</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Kayıt Ol</button>
                </form>

                <div class="text-center mt-3">
                    <a href="login.php" class="text-decoration-none">Zaten hesabınız var mı? Giriş yap</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
