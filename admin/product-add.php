<?php include 'includes/header.php'; ?>

<?php
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'] ?? '';
    $category_id = $_POST['category_id'] ?? '';
    $description = $_POST['description'] ?? '';
    $image_url = $_POST['image_url'] ?? ''; 

    // Dosya yükleme işlemi
    if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] == 0) {
        $upload_dir = '../assets/uploads/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        $file_ext = strtolower(pathinfo($_FILES['image_file']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        
        if (in_array($file_ext, $allowed)) {
            $new_filename = uniqid() . '.' . $file_ext;
            $upload_path = $upload_dir . $new_filename;
            
            if (move_uploaded_file($_FILES['image_file']['tmp_name'], $upload_path)) {
                $image_url = 'assets/uploads/' . $new_filename;
            } else {
                $error = 'Dosya yüklenirken bir hata oluştu.';
            }
        } else {
            $error = 'Sadece JPG, PNG, GIF ve WEBP dosyaları yüklenebilir.';
        }
    }

    if (!$error && $name && $category_id) {
        try {
            $stmt = $pdo->prepare("INSERT INTO products (name, category_id, description, image_url) VALUES (?, ?, ?, ?)");
            $stmt->execute([$name, $category_id, $description, $image_url]);
            $success = 'Ürün başarıyla eklendi!';
        } catch (PDOException $e) {
            $error = 'Hata: ' . $e->getMessage();
        }
    } else if (!$error) {
        $error = 'Lütfen zorunlu alanları doldurun.';
    }
}
?>

<div class="page-header">
    <h1 class="page-title">Yeni Ürün Ekle</h1>
    <a href="/yonetim/urunler" class="btn" style="background-color: #95a5a6; color: #fff;">&larr; Geri Dön</a>
</div>

<div class="form-container">
    <?php if ($error): ?>
        <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 4px; margin-bottom: 20px;">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>
    
    <?php if ($success): ?>
        <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 4px; margin-bottom: 20px;">
            <?php echo $success; ?>
        </div>
    <?php endif; ?>

    <form action="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Ürün Adı *</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label for="category_id">Kategori *</label>
            <select id="category_id" name="category_id" class="form-control" required>
                <option value="">Seçiniz</option>
                <?php
                $cats = $pdo->query("SELECT * FROM categories ORDER BY name");
                while ($cat = $cats->fetch()) {
                    echo '<option value="' . $cat['id'] . '">' . htmlspecialchars($cat['name']) . '</option>';
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label>Ürün Resmi Yükle</label>
            <input type="file" name="image_file" class="form-control" accept="image/*">
        </div>

        <div class="form-group">
            <label for="image_url">Veya Resim URL Girin</label>
            <input type="text" id="image_url" name="image_url" class="form-control" placeholder="https://...">
            <small style="color: #7f8c8d;">Bilgisayardan dosya yüklerseniz URL alanı yoksayılır.</small>
        </div>

        <div class="form-group">
            <label for="description">Açıklama</label>
            <textarea id="description" name="description" class="form-control" rows="5"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Kaydet</button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
