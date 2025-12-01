<?php
session_start();

// Reset isteği varsa config dosyasını sil
if (isset($_GET['reset']) && $_GET['reset'] == 'true') {
    if (file_exists('includes/config.php')) {
        unlink('includes/config.php');
    }
    header("Location: install.php");
    exit;
}

if (file_exists('includes/config.php')) {
    die("Kurulum zaten tamamlanmış. Yeniden kurmak için <a href='?reset=true'>buraya tıklayarak ayarları sıfırlayın</a>.");
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $db_host = $_POST['db_host'];
    $db_name = $_POST['db_name'];
    $db_user = $_POST['db_user'];
    $db_pass = $_POST['db_pass'];
    
    $admin_user = $_POST['admin_user'];
    $admin_pass = $_POST['admin_pass'];

    try {
        // Test Connection
        $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Tabloları oluştur (Eğer 'skip_tables' seçili değilse)
        if (!isset($_POST['skip_tables'])) {
            // 1. Admin Users
            $pdo->exec("CREATE TABLE IF NOT EXISTS admin_users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(50) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )");

            // 2. Site Settings
            $pdo->exec("CREATE TABLE IF NOT EXISTS site_settings (
                id INT AUTO_INCREMENT PRIMARY KEY,
                site_title VARCHAR(255) DEFAULT 'Seçici Tente&Branda',
                browser_title VARCHAR(255),
                logo_url VARCHAR(255),
                favicon_url VARCHAR(255),
                hero_title VARCHAR(255),
                hero_description TEXT,
                hero_image_url VARCHAR(255),
                about_title VARCHAR(255),
                about_text TEXT,
                about_mission TEXT,
                about_vision TEXT,
                about_image_url VARCHAR(255),
                home_about_title VARCHAR(255) DEFAULT 'Hakkımızda',
                home_about_text TEXT,
                home_about_image_url VARCHAR(255),
                contact_phone VARCHAR(50),
                contact_phone_2 VARCHAR(50),
                contact_email VARCHAR(100),
                contact_address TEXT,
                footer_about TEXT,
                social_facebook VARCHAR(255),
                social_instagram VARCHAR(255),
                social_twitter VARCHAR(255),
                social_linkedin VARCHAR(255)
            )");

            // 3. Categories
            $pdo->exec("CREATE TABLE IF NOT EXISTS categories (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                slug VARCHAR(255)
            )");

            // 4. Products
            $pdo->exec("CREATE TABLE IF NOT EXISTS products (
                id INT AUTO_INCREMENT PRIMARY KEY,
                category_id INT,
                name VARCHAR(255) NOT NULL,
                slug VARCHAR(255),
                description TEXT,
                image_url VARCHAR(255),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
            )");

            // 5. Messages
            $pdo->exec("CREATE TABLE IF NOT EXISTS messages (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(100) NOT NULL,
                email VARCHAR(100) NOT NULL,
                phone VARCHAR(20),
                subject VARCHAR(255),
                message TEXT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )");

            // 6. Services
            $pdo->exec("CREATE TABLE IF NOT EXISTS services (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                image_url VARCHAR(255),
                display_order INT DEFAULT 0,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )");

            // 7. Service Areas
            $pdo->exec("CREATE TABLE IF NOT EXISTS service_areas (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                image_url VARCHAR(255),
                display_order INT DEFAULT 0,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )");

            // Insert Admin User
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM admin_users WHERE username = ?");
            $stmt->execute([$admin_user]);
            if ($stmt->fetchColumn() == 0) {
                $hashed_pass = password_hash($admin_pass, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("INSERT INTO admin_users (username, password) VALUES (?, ?)");
                $stmt->execute([$admin_user, $hashed_pass]);
            }

            // Insert Default Settings if empty
            $stmt = $pdo->query("SELECT COUNT(*) FROM site_settings");
            if ($stmt->fetchColumn() == 0) {
                $pdo->exec("INSERT INTO site_settings (site_title, hero_title, hero_description, contact_email) VALUES ('Seçici Tente', 'Modern Gölgelendirme', 'Kaliteli çözümler.', 'info@example.com')");
            }
        }

        // Write Config File
        $config_content = "<?php\n";
        $config_content .= "\$db_host = '$db_host';\n";
        $config_content .= "\$db_name = '$db_name';\n";
        $config_content .= "\$db_user = '$db_user';\n";
        $config_content .= "\$db_pass = '$db_pass';\n";
        $config_content .= "?>";

        file_put_contents('includes/config.php', $config_content);

        $success = "Kurulum başarıyla tamamlandı! Yönlendiriliyorsunuz...";
        header("Refresh: 2; url=index.php");

    } catch (PDOException $e) {
        if ($e->getCode() == 42000 || $e->getCode() == 1142) {
            $error = "<strong>Yetki Hatası:</strong> Veritabanı kullanıcısının tablo oluşturma yetkisi yok.<br>Lütfen hosting panelinizden kullanıcıya 'CREATE' yetkisi verin veya tabloları manuel yüklediyseniz aşağıdaki 'Tablolar zaten var' seçeneğini işaretleyin.";
        } else {
            $error = "Veritabanı Hatası: " . $e->getMessage();
        }
    } catch (Exception $e) {
        $error = "Hata: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site Kurulumu</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f4f6f9; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .install-card { background: #fff; padding: 40px; border-radius: 10px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); width: 100%; max-width: 500px; }
        h1 { text-align: center; color: #2c3e50; margin-bottom: 30px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: 500; color: #555; }
        input { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; font-family: inherit; }
        button { width: 100%; padding: 12px; background: #e67e22; color: #fff; border: none; border-radius: 5px; font-weight: 600; cursor: pointer; transition: background 0.3s; }
        button:hover { background: #d35400; }
        .alert { padding: 15px; border-radius: 5px; margin-bottom: 20px; font-size: 14px; }
        .alert-danger { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    </style>
</head>
<body>
    <div class="install-card">
        <h1>Site Kurulumu</h1>
        
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php else: ?>
            <form method="POST">
                <h3 style="margin-bottom: 15px; border-bottom: 1px solid #eee; padding-bottom: 10px;">Veritabanı Bilgileri</h3>
                <div class="form-group">
                    <label>Veritabanı Sunucusu (Host)</label>
                    <input type="text" name="db_host" value="localhost" required>
                </div>
                <div class="form-group">
                    <label>Veritabanı Adı</label>
                    <input type="text" name="db_name" required>
                </div>
                <div class="form-group">
                    <label>Veritabanı Kullanıcısı</label>
                    <input type="text" name="db_user" required>
                </div>
                <div class="form-group">
                    <label>Veritabanı Şifresi</label>
                    <input type="password" name="db_pass">
                </div>

                <div class="form-group" style="display: flex; align-items: center; gap: 10px; margin-top: 10px;">
                    <input type="checkbox" name="skip_tables" id="skip_tables" style="width: auto; margin: 0;">
                    <label for="skip_tables" style="margin: 0; font-weight: normal; cursor: pointer;">Tablolar zaten var, kurulumu atla (Sadece bağlan)</label>
                </div>

                <h3 style="margin-bottom: 15px; border-bottom: 1px solid #eee; padding-bottom: 10px; margin-top: 30px;">Yönetici Hesabı</h3>
                <div class="form-group">
                    <label>Admin Kullanıcı Adı</label>
                    <input type="text" name="admin_user" required>
                </div>
                <div class="form-group">
                    <label>Admin Şifresi</label>
                    <input type="password" name="admin_pass" required>
                </div>

                <button type="submit">Kurulumu Tamamla</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
