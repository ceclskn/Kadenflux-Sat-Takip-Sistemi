<?php
require 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

try {
    $stmt = $conn->prepare("SELECT id, product_name, price, sale_date FROM sales WHERE user_id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $satislar = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $satislar = [];
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Satış Paneli - KadenFlux</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Merhaba, <?php echo htmlspecialchars($_SESSION['username']); ?> 👋</h2>
        <a href="logout.php" class="btn btn-outline-danger">Çıkış Yap</a>
    </div>

    <a href="add_sale.php" class="btn btn-primary mb-3">➕ Yeni Satış Ekle</a>

    <?php if (count($satislar) > 0): ?>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Ürün Adı</th>
                <th>Tarih</th>
                <th>Fiyat (₺)</th>
                <th>İşlem</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($satislar as $satis): ?>
            <tr>
                <td><?= htmlspecialchars($satis['product_name']) ?></td>
                <td><?= htmlspecialchars($satis['sale_date']) ?></td>
                <td><?= htmlspecialchars(number_format($satis['price'], 2)) ?></td>
                <td>
                   <a href="edit_sale.php?id=<?= $satis['id'] ?>" class="btn btn-sm btn-warning">Düzenle</a>

                    <a href="delete_sale.php?id=<?= $satis['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Silmek istediğine emin misin?')">Sil</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
        <div class="alert alert-info">Henüz satış verisi bulunmamaktadır.</div>
    <?php endif; ?>
</body>
</html>
