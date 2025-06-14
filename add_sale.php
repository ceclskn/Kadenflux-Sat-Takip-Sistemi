<?php
require 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$msg = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_name = trim($_POST['product_name']);
    $price = $_POST['price'];
    $sale_date = $_POST['sale_date'];

    if (!empty($product_name) && !empty($price) && !empty($sale_date)) {
        try {
            $stmt = $conn->prepare("INSERT INTO sales (user_id, product_name, price, sale_date) VALUES (?, ?, ?, ?)");
            $stmt->execute([
                $_SESSION['user_id'],
                $product_name,
                $price,
                $sale_date
            ]);
            $msg = "Yeni satış başarıyla eklendi!";
        } catch (PDOException $e) {
            $msg = "Hata: " . $e->getMessage();
        }
    } else {
        $msg = "Lütfen tüm alanları doldurun.";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Yeni Satış Ekle - KadenFlux</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">

    <h2 class="mb-4">Yeni Satış Ekle</h2>
    
    <?php if (!empty($msg)) : ?>
        <div class="alert alert-info"><?php echo $msg; ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Ürün Adı</label>
            <input type="text" name="product_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Fiyat (₺)</label>
            <input type="number" step="0.01" name="price" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Satış Tarihi</label>
            <input type="date" name="sale_date" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Satışı Kaydet</button>
        <a href="dashboard.php" class="btn btn-secondary">Geri Dön</a>
    </form>

</body>
</html>
