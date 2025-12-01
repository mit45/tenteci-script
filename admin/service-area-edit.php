<?php include 'includes/header.php'; ?>

<?php
$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: /yonetim/hizmet-bolgeleri');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM service_areas WHERE id = ?");
$stmt->execute([$id]);
$area = $stmt->fetch();

if (!$area) {
    header('Location: /yonetim/hizmet-bolgeleri');
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $display_order = (int)$_POST['display_order'];
    $image_url = $area['image_url'];

    // Görsel Yükleme
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $upload_dir = '../assets/uploads/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        $file_ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        
        if (in_array($file_ext, $allowed)) {
            $new_filename = uniqid() . '.' . $file_ext;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $new_filename)) {
                $image_url = 'assets/uploads/' . $new_filename;
            }
        }
    } elseif (!empty($_POST['image_url_text'])) {
        $image_url = $_POST['image_url_text'];
    }

    if (empty($name)) {
        $error = 'Bölge adı zorunludur.';
    } else {
        try {
            $stmt = $pdo->prepare("UPDATE service_areas SET name = ?, image_url = ?, display_order = ? WHERE id = ?");
            $stmt->execute([$name, $image_url, $display_order, $id]);
            $success = 'Bölge başarıyla güncellendi.';
            
            // Refresh data
            $stmt = $pdo->prepare("SELECT * FROM service_areas WHERE id = ?");
            $stmt->execute([$id]);
            $area = $stmt->fetch();
            
        } catch (PDOException $e) {
            $error = 'Hata: ' . $e->getMessage();
        }
    }
}
?>

<div class="page-header">
    <h1 class="page-title">Bölge Düzenle</h1>
    <a href="/yonetim/hizmet-bolgeleri" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Geri Dön</a>
</div>

<div class="form-container">
    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>

    <form action="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Bölge Adı</label>
            <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($area['name']); ?>" required>
        </div>
        
        <div class="form-group">
            <label>Sıralama</label>
            <input type="number" name="display_order" class="form-control" value="<?php echo htmlspecialchars($area['display_order']); ?>">
        </div>

        <div class="form-group">
            <label>Mevcut Görsel</label>
            <?php if ($area['image_url']): ?>
                <div style="margin: 10px 0;">
                    <?php $img_src = (strpos($area['image_url'], 'http') === 0) ? $area['image_url'] : '../' . $area['image_url']; ?>
                    <img src="<?php echo htmlspecialchars($img_src); ?>" style="max-width: 200px; border-radius: 4px;">
                </div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label>Yeni Görsel Yükle</label>
            <input type="file" name="image" class="form-control">
        </div>

        <div class="form-group">
            <label>Veya Görsel URL</label>
            <input type="text" name="image_url_text" class="form-control" value="<?php echo (strpos($area['image_url'], 'http') === 0) ? htmlspecialchars($area['image_url']) : ''; ?>">
        </div>

        <button type="submit" class="btn btn-primary">Güncelle</button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>