<?php
require 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$msg = '';
$sale_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($sale_id <= 0) {
    header("Location: dashboard.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $stmt = $conn->prepare("DELETE FROM sales WHERE id = ? AND user_id = ?");
        $stmt->execute([$sale_id, $_SESSION['user_id']]);

        if ($stmt->rowCount() > 0) {
            $msg = "Satış başarıyla silindi!";
        } else {
            $msg = "Satış bulunamadı veya silme yetkiniz yok.";
        }
    } catch (PDOException $e) {
        $msg = "Hata oluştu: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Satış Sil - KadenFlux</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">

    <h2>Satışı Sil</h2>

    <?php if (!empty($msg)) : ?>
        <div class="alert alert-info"><?= htmlspecialchars($msg) ?></div>
        <a href="dashboard.php" class="btn btn-secondary">Geri Dön</a>
    <?php else: ?>
        <div class="alert alert-warning">
            <strong>Dikkat!</strong> Bu satışı silmek istediğinizden emin misiniz?
        </div>
        <form method="POST">
            <button type="submit" class="btn btn-danger">Evet, Sil</button>
            <a href="dashboard.php" class="btn btn-secondary">Hayır, Geri Dön</a>
        </form>
    <?php endif; ?>
</body>
</html>
