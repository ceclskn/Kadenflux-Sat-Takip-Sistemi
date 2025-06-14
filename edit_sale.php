<?php
require 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$sale_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($sale_id <= 0) {
    header("Location: dashboard.php");
    exit;
}

// Satışı veritabanından çek
$stmt = $conn->prepare("SELECT product_name, sale_date, price FROM sales WHERE id = ? AND user_id = ?");
$stmt->execute([$sale_id, $_SESSION['user_id']]);
$sale = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$sale) {
    // Satış bulunamadıysa dashboard'a yönlendir
    header("Location: dashboard.php");
    exit;
}

$msg = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $urun_adi = trim($_POST['urun_adi']);
    $satis_tarihi = $_POST['satis_tarihi'];
    $fiyat = $_POST['fiyat'];

    if ($urun_adi && $satis_tarihi && is_numeric($fiyat)) {
        $updateStmt = $conn->prepare("UPDATE sales SET product_name = ?, sale_date = ?, price = ? WHERE id = ? AND user_id = ?");
        $updateStmt->execute([$urun_adi, $satis_tarihi, $fiyat, $sale_id, $_SESSION['user_id']]);

        $msg = "Satış başarıyla güncellendi!";
        // Güncellenen verileri tekrar çek (opsiyonel)
        $sale = [
            'product_name' => $urun_adi,
            'sale_date' => $satis_tarihi,
            'price' => $fiyat,
        ];
    } else {
        $msg = "Lütfen tüm alanları doğru doldurun.";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Satış Düzenle - KadenFlux</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">

    <h2>Satış Bilgilerini Güncelle</h2>

    <?php if (!empty($msg)) echo "<div class='alert alert-info'>$msg</div>"; ?>

    <form method="POST">
        <div class="mb-3">
            <label>Ürün Adı</label>
            <input type="text" name="urun_adi" class="form-control" required value="<?= htmlspecialchars($sale['product_name']) ?>">
        </div>
        <div class="mb-3">
            <label>Satış Tarihi</label>
            <input type="date" name="satis_tarihi" class="form-control" required value="<?= htmlspecialchars($sale['sale_date']) ?>">
        </div>
        <div class="mb-3">
            <label>Fiyat ($)</label>
            <input type="number" step="0.01" name="fiyat" class="form-control" required value="<?= htmlspecialchars($sale['price']) ?>">
        </div>
        <button type="submit" class="btn btn-primary">Güncelle</button>
        <a href="dashboard.php" class="btn btn-secondary">Geri Dön</a>
    </form>
</body>
</html>
