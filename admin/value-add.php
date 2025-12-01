<?php include 'includes/header.php'; ?>

<?php
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $icon = $_POST['icon'] ?? 'fas fa-check';
    $display_order = $_POST['display_order'] ?? 0;

    if ($title && $description) {
        try {
            $stmt = $pdo->prepare("INSERT INTO company_values (title, description, icon, display_order) VALUES (?, ?, ?, ?)");
            $stmt->execute([$title, $description, $icon, $display_order]);
            $success = 'Değer başarıyla eklendi!';
        } catch (PDOException $e) {
            $error = 'Hata: ' . $e->getMessage();
        }
    } else {
        $error = 'Lütfen başlık ve açıklama alanlarını doldurun.';
    }
}
?>

<div class="page-header">
    <h1 class="page-title">Yeni Değer Ekle</h1>
    <a href="/yonetim/degerler" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Geri Dön</a>
</div>

<div class="form-container">
    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>
    
    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form action="" method="POST">
        <div class="form-group">
            <label>Başlık</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label>Açıklama</label>
            <textarea name="description" class="form-control" rows="3" required></textarea>
        </div>

        <div class="form-group">
            <label>İkon Sınıfı (FontAwesome)</label>
            <input type="text" name="icon" class="form-control" value="fas fa-check" placeholder="Örn: fas fa-star">
            <small><a href="https://fontawesome.com/v5/search?m=free" target="_blank">İkonları buradan bulabilirsiniz</a></small>
        </div>

        <div class="form-group">
            <label>Sıralama</label>
            <input type="number" name="display_order" class="form-control" value="0">
        </div>

        <button type="submit" class="btn btn-primary">Kaydet</button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
