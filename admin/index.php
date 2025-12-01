<?php include 'includes/header.php'; ?>

<?php
// İstatistikleri çek
$product_count = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
$message_count = $pdo->query("SELECT COUNT(*) FROM messages")->fetchColumn();
$category_count = $pdo->query("SELECT COUNT(*) FROM categories")->fetchColumn();
?>

<div class="page-header">
    <h1 class="page-title">Kontrol Paneli</h1>
</div>

<div class="dashboard-cards">
    <div class="card">
        <div class="card-icon">
            <i class="fas fa-box"></i>
        </div>
        <div class="card-info">
            <h3><?php echo $product_count; ?></h3>
            <p>Toplam Ürün</p>
        </div>
    </div>
    <div class="card">
        <div class="card-icon" style="background-color: #3498db;">
            <i class="fas fa-envelope"></i>
        </div>
        <div class="card-info">
            <h3><?php echo $message_count; ?></h3>
            <p>Gelen Mesaj</p>
        </div>
    </div>
    <div class="card">
        <div class="card-icon" style="background-color: #2ecc71;">
            <i class="fas fa-tags"></i>
        </div>
        <div class="card-info">
            <h3><?php echo $category_count; ?></h3>
            <p>Kategori</p>
        </div>
    </div>
</div>

<div class="table-container">
    <h3 style="margin-bottom: 20px;">Son Gelen Mesajlar</h3>
    <table>
        <thead>
            <tr>
                <th>Tarih</th>
                <th>Ad Soyad</th>
                <th>Konu</th>
                <th>İşlem</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $stmt = $pdo->query("SELECT * FROM messages ORDER BY created_at DESC LIMIT 5");
            while ($row = $stmt->fetch()) {
                echo '<tr>';
                echo '<td>' . date('d.m.Y H:i', strtotime($row['created_at'])) . '</td>';
                echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                echo '<td>' . htmlspecialchars($row['subject']) . '</td>';
                echo '<td><a href="/yonetim/mesajlar" class="btn btn-primary" style="padding: 5px 10px; font-size: 12px;">Oku</a></td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
</div>

<?php include 'includes/footer.php'; ?>
