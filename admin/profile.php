<?php include 'includes/header.php'; ?>

<?php
$success = '';
$error = '';
$admin_id = $_SESSION['admin_id'];

// Mevcut bilgileri çek
$stmt = $pdo->prepare("SELECT * FROM admin_users WHERE id = ?");
$stmt->execute([$admin_id]);
$admin = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if ($username && $current_password) {
        // Mevcut şifreyi kontrol et
        if (password_verify($current_password, $admin['password'])) {
            
            // Yeni şifre varsa ve eşleşiyorsa
            if ($new_password) {
                if ($new_password === $confirm_password) {
                    $new_hash = password_hash($new_password, PASSWORD_DEFAULT);
                    $update = $pdo->prepare("UPDATE admin_users SET username = ?, password = ? WHERE id = ?");
                    $update->execute([$username, $new_hash, $admin_id]);
                    
                    $_SESSION['admin_username'] = $username; // Session'ı güncelle
                    $success = 'Bilgileriniz ve şifreniz başarıyla güncellendi!';
                } else {
                    $error = 'Yeni şifreler uyuşmuyor.';
                }
            } else {
                // Sadece kullanıcı adı değişiyorsa
                $update = $pdo->prepare("UPDATE admin_users SET username = ? WHERE id = ?");
                $update->execute([$username, $admin_id]);
                
                $_SESSION['admin_username'] = $username; // Session'ı güncelle
                $success = 'Kullanıcı adı başarıyla güncellendi!';
            }
            
            // Güncel veriyi tekrar çek
            $stmt = $pdo->prepare("SELECT * FROM admin_users WHERE id = ?");
            $stmt->execute([$admin_id]);
            $admin = $stmt->fetch();
            
        } else {
            $error = 'Mevcut şifreniz hatalı.';
        }
    } else {
        $error = 'Lütfen gerekli alanları doldurun.';
    }
}
?>

<div class="page-header">
    <h1 class="page-title">Profil Ayarları</h1>
</div>

<div class="form-container">
    <?php if ($success): ?>
        <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 4px; margin-bottom: 20px;">
            <?php echo $success; ?>
        </div>
    <?php endif; ?>
    
    <?php if ($error): ?>
        <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 4px; margin-bottom: 20px;">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <form action="" method="POST">
        <div class="form-group">
            <label>Kullanıcı Adı</label>
            <input type="text" name="username" class="form-control" value="<?php echo htmlspecialchars($admin['username']); ?>" required>
        </div>

        <hr style="margin: 30px 0; border: 0; border-top: 1px solid #eee;">
        <h3 style="margin-bottom: 20px; font-size: 18px;">Şifre Değiştir (İsteğe Bağlı)</h3>

        <div class="form-group">
            <label>Yeni Şifre</label>
            <input type="password" name="new_password" class="form-control" placeholder="Değiştirmek istemiyorsanız boş bırakın">
        </div>

        <div class="form-group">
            <label>Yeni Şifre (Tekrar)</label>
            <input type="password" name="confirm_password" class="form-control" placeholder="Değiştirmek istemiyorsanız boş bırakın">
        </div>

        <hr style="margin: 30px 0; border: 0; border-top: 1px solid #eee;">

        <div class="form-group">
            <label>Mevcut Şifre (Değişiklikleri kaydetmek için zorunlu)</label>
            <input type="password" name="current_password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Güncelle</button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
