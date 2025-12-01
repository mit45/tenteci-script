<?php include 'includes/header.php'; ?>

<?php
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'] ?? '';
    
    if ($name) {
        // Slug oluştur
        function createSlug($str, $delimiter = '-') {
            $turkish = array("ı", "ğ", "ü", "ş", "ö", "ç", "İ", "Ğ", "Ü", "Ş", "Ö", "Ç");
            $english = array("i", "g", "u", "s", "o", "c", "i", "g", "u", "s", "o", "c");
            $str = str_replace($turkish, $english, $str);
            $str = strtolower(trim($str));
            $str = preg_replace('/[^a-z0-9-]/', '-', $str);
            $str = preg_replace('/-+/', "-", $str);
            return trim($str, '-');
        }

        $slug = createSlug($name);

        try {
            $stmt = $pdo->prepare("INSERT INTO categories (name, slug) VALUES (?, ?)");
            $stmt->execute([$name, $slug]);
            $success = 'Kategori başarıyla eklendi!';
        } catch (PDOException $e) {
            $error = 'Hata: ' . $e->getMessage();
        }
    } else {
        $error = 'Lütfen kategori adını girin.';
    }
}
?>

<div class="page-header">
    <h1 class="page-title">Yeni Kategori Ekle</h1>
    <a href="/yonetim/kategoriler" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Geri Dön</a>
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
            <label>Kategori Adı</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Kaydet</button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
