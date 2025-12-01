<?php
$config_file = __DIR__ . '/config.php';

if (file_exists($config_file)) {
    require_once $config_file;
    $host = $db_host;
    $dbname = $db_name;
    $username = $db_user;
    $password = $db_pass;
} else {
    // Config dosyası yoksa kurulum sayfasına yönlendir
    $current_script = basename($_SERVER['PHP_SELF']);
    if ($current_script != 'install.php') {
        header("Location: /install.php");
        exit;
    }
    return;
}

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // Site ayarlarını çek (Hata oluşursa yoksay - Tablo henüz yoksa site çökmesin)
    $settings = [];
    try {
        $stmt = $pdo->query("SELECT * FROM site_settings LIMIT 1");
        $settings = $stmt->fetch();
        if (!$settings) { $settings = []; }
    } catch (PDOException $e) {
        // Tablo yoksa sessizce devam et, varsayılan değerler kullanılır
    }

} catch (PDOException $e) {
    // Eğer kurulum sayfasındaysak hatayı fırlat
    if (basename($_SERVER['PHP_SELF']) == 'install.php') {
        throw $e;
    }
    
    // Değilse kullanıcı dostu hata göster ve sıfırlama linki ver
    echo '<div style="font-family: sans-serif; padding: 40px; text-align: center; max-width: 600px; margin: 50px auto; background: #fff; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">';
    echo '<h2 style="color: #e74c3c; margin-top: 0;">Veritabanı Bağlantı Hatası</h2>';
    echo '<p style="color: #555; line-height: 1.6;">' . htmlspecialchars($e->getMessage()) . '</p>';
    echo '<p style="color: #777; font-size: 0.9em;">Yapılandırma dosyasındaki (includes/config.php) bilgiler hatalı olabilir.</p>';
    echo '<div style="margin-top: 25px;">';
    echo '<a href="install.php?reset=true" style="background: #3498db; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-weight: 500; transition: background 0.3s;">Kurulumu Tekrar Başlat</a>';
    echo '</div>';
    echo '</div>';
    echo '<style>body { background-color: #f4f6f9; margin: 0; }</style>';
    exit;
}
?>
