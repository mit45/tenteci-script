<?php include 'includes/header.php'; ?>

<?php
$success = '';
$error = '';

// Mevcut ayarları çek
$stmt = $pdo->query("SELECT * FROM site_settings LIMIT 1");
$settings = $stmt->fetch();

if (!$settings) {
    echo '<div style="padding: 20px; color: red;">Ayarlar tablosu bulunamadı. Lütfen önce <a href="setup_settings.php">setup_settings.php</a> dosyasını çalıştırın.</div>';
    include 'includes/footer.php';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Dosya yükleme fonksiyonu
        function handleUpload($fileInputName, $currentUrl, &$errorMsg) {
            if (isset($_FILES[$fileInputName]) && $_FILES[$fileInputName]['error'] == 0) {
                $upload_dir = '../assets/uploads/';
                if (!file_exists($upload_dir)) {
                    if (!mkdir($upload_dir, 0777, true)) {
                        $errorMsg .= "Klasör oluşturulamadı: $upload_dir. ";
                        return $currentUrl;
                    }
                }
                
                if (!is_writable($upload_dir)) {
                    $errorMsg .= "Klasör yazılabilir değil: $upload_dir. ";
                    return $currentUrl;
                }
                
                $file_ext = strtolower(pathinfo($_FILES[$fileInputName]['name'], PATHINFO_EXTENSION));
                $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];
                
                if (in_array($file_ext, $allowed)) {
                    $new_filename = uniqid() . '.' . $file_ext;
                    $upload_path = $upload_dir . $new_filename;
                    
                    if (move_uploaded_file($_FILES[$fileInputName]['tmp_name'], $upload_path)) {
                        return 'assets/uploads/' . $new_filename;
                    } else {
                        $errorMsg .= "Dosya taşınamadı. ";
                    }
                } else {
                    $errorMsg .= "Geçersiz dosya türü: $file_ext. ";
                }
            } elseif (isset($_FILES[$fileInputName]) && $_FILES[$fileInputName]['error'] != 4) {
                 // Error 4 is "No file uploaded", which is fine. Other errors are bad.
                 $uploadErrors = array(
                    1 => 'Dosya php.ini limitini aşıyor',
                    2 => 'Dosya HTML form limitini aşıyor',
                    3 => 'Dosya kısmen yüklendi',
                    6 => 'Geçici klasör eksik',
                    7 => 'Diske yazılamadı',
                    8 => 'Uzantı yüklemeyi durdurdu',
                );
                $errorCode = $_FILES[$fileInputName]['error'];
                $errorMsg .= "Yükleme hatası ($errorCode): " . ($uploadErrors[$errorCode] ?? 'Bilinmeyen hata') . ". ";
            }
            return $currentUrl; // Yükleme yoksa veya başarısızsa mevcut URL'yi koru
        }

        // Resimleri işle
        $logo_url = handleUpload('logo_file', $_POST['logo_url'], $error);
        $favicon_url = handleUpload('favicon_file', $_POST['favicon_url'] ?? 'assets/images/favicon.ico', $error);
        $hero_image_url = handleUpload('hero_image_file', $_POST['hero_image_url'], $error);
        $about_image_url = handleUpload('about_image_file', $_POST['about_image_url'], $error);
        $home_about_image_url = handleUpload('home_about_image_file', $_POST['home_about_image_url'] ?? '', $error);

        $sql = "UPDATE site_settings SET 
            site_title = ?, 
            browser_title = ?,
            logo_url = ?, 
            favicon_url = ?,
            hero_title = ?, 
            hero_description = ?, 
            hero_image_url = ?, 
            about_title = ?, 
            about_text = ?, 
            about_mission = ?, 
            about_vision = ?, 
            about_image_url = ?, 
            home_about_title = ?,
            home_about_text = ?,
            home_about_image_url = ?,
            contact_phone = ?, 
            contact_phone_2 = ?,
            contact_email = ?, 
            contact_address = ?, 
            footer_about = ?,
            social_facebook = ?,
            social_instagram = ?,
            social_twitter = ?,
            social_linkedin = ?
            WHERE id = ?";
            
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $_POST['site_title'],
            $_POST['browser_title'] ?? '',
            $logo_url,
            $favicon_url,
            $_POST['hero_title'],
            $_POST['hero_description'],
            $hero_image_url,
            $_POST['about_title'],
            $_POST['about_text'],
            $_POST['about_mission'],
            $_POST['about_vision'],
            $about_image_url,
            $_POST['home_about_title'] ?? '',
            $_POST['home_about_text'] ?? '',
            $home_about_image_url,
            $_POST['contact_phone'],
            $_POST['contact_phone_2'] ?? '',
            $_POST['contact_email'],
            $_POST['contact_address'],
            $_POST['footer_about'],
            $_POST['social_facebook'],
            $_POST['social_instagram'],
            $_POST['social_twitter'],
            $_POST['social_linkedin'],
            $settings['id']
        ]);
        
        $success = 'Ayarlar başarıyla güncellendi!';
        
        // Güncel veriyi tekrar çek
        $stmt = $pdo->query("SELECT * FROM site_settings LIMIT 1");
        $settings = $stmt->fetch();
        
    } catch (PDOException $e) {
        $error = 'Hata: ' . $e->getMessage();
    }
}
?>

<div class="page-header">
    <h1 class="page-title">Site Ayarları</h1>
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

    <form action="" method="POST" enctype="multipart/form-data">
        
        <!-- Tab Navigation -->
        <div class="settings-tabs">
            <button type="button" class="tab-btn active" onclick="openTab(event, 'general')">Genel Ayarlar</button>
            <button type="button" class="tab-btn" onclick="openTab(event, 'hero')">Ana Sayfa (Hero)</button>
            <button type="button" class="tab-btn" onclick="openTab(event, 'home-about')">Ana Sayfa (Hakkında)</button>
            <button type="button" class="tab-btn" onclick="openTab(event, 'about')">Hakkımızda Sayfası</button>
            <button type="button" class="tab-btn" onclick="openTab(event, 'contact')">İletişim</button>
            <button type="button" class="tab-btn" onclick="openTab(event, 'social')">Sosyal Medya</button>
            <button type="button" class="tab-btn" onclick="openTab(event, 'footer')">Footer</button>
        </div>

        <!-- General Settings -->
        <div id="general" class="tab-content active">
            <h2 style="margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 10px;">Genel Ayarlar</h2>
            <div class="form-group">
                <label>Site Başlığı (Logo Yanı)</label>
                <input type="text" name="site_title" class="form-control" value="<?php echo htmlspecialchars($settings['site_title']); ?>">
            </div>
            <div class="form-group">
                <label>Tarayıcı Başlığı (Sekme Adı)</label>
                <input type="text" name="browser_title" class="form-control" value="<?php echo htmlspecialchars($settings['browser_title'] ?? ''); ?>">
                <small style="color: #666;">Boş bırakılırsa Site Başlığı kullanılır.</small>
            </div>
            <div class="form-group">
                <label>Logo Yükle</label>
                <input type="file" name="logo_file" class="form-control">
            </div>
            <div class="form-group">
                <label>Logo URL (veya mevcut)</label>
                <input type="text" name="logo_url" class="form-control" value="<?php echo htmlspecialchars($settings['logo_url']); ?>">
            </div>

            <div class="form-group">
                <label>Favicon (Tarayıcı İkonu) Yükle</label>
                <input type="file" name="favicon_file" class="form-control">
            </div>
            <div class="form-group">
                <label>Favicon URL (veya mevcut)</label>
                <input type="text" name="favicon_url" class="form-control" value="<?php echo htmlspecialchars($settings['favicon_url'] ?? 'assets/images/favicon.ico'); ?>">
                <?php if (!empty($settings['favicon_url'])): ?>
                    <div style="margin-top: 10px;">
                        <img src="../<?php echo htmlspecialchars($settings['favicon_url']); ?>" style="width: 32px; height: 32px; border: 1px solid #ddd; padding: 2px;">
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Hero Settings -->
        <div id="hero" class="tab-content">
            <h2 style="margin: 0 0 20px; border-bottom: 1px solid #eee; padding-bottom: 10px;">Ana Sayfa (Hero Alanı)</h2>
            <div class="form-group">
                <label>Başlık</label>
                <input type="text" name="hero_title" class="form-control" value="<?php echo htmlspecialchars($settings['hero_title']); ?>">
            </div>
            <div class="form-group">
                <label>Açıklama</label>
                <textarea name="hero_description" class="form-control" rows="3"><?php echo htmlspecialchars($settings['hero_description']); ?></textarea>
            </div>
            <div class="form-group">
                <label>Arka Plan Resmi Yükle</label>
                <input type="file" name="hero_image_file" class="form-control">
            </div>
            <div class="form-group">
                <label>Arka Plan Resim URL (veya mevcut)</label>
                <input type="text" name="hero_image_url" class="form-control" value="<?php echo htmlspecialchars($settings['hero_image_url']); ?>">
            </div>
        </div>

        <!-- Home About Settings -->
        <div id="home-about" class="tab-content">
            <h2 style="margin: 0 0 20px; border-bottom: 1px solid #eee; padding-bottom: 10px;">Ana Sayfa (Hakkımızda Bölümü)</h2>
            <div class="form-group">
                <label>Başlık</label>
                <input type="text" name="home_about_title" class="form-control" value="<?php echo htmlspecialchars($settings['home_about_title'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label>Kısa Metin</label>
                <textarea name="home_about_text" class="form-control" rows="4"><?php echo htmlspecialchars($settings['home_about_text'] ?? ''); ?></textarea>
            </div>
            <div class="form-group">
                <label>Görsel Yükle</label>
                <input type="file" name="home_about_image_file" class="form-control">
            </div>
            <div class="form-group">
                <label>Görsel URL (veya mevcut)</label>
                <input type="text" name="home_about_image_url" class="form-control" value="<?php echo htmlspecialchars($settings['home_about_image_url'] ?? ''); ?>">
                <?php if (!empty($settings['home_about_image_url'])): ?>
                    <div style="margin-top: 10px;">
                        <img src="../<?php echo htmlspecialchars($settings['home_about_image_url']); ?>" style="max-width: 200px; border-radius: 4px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- About Page Settings -->
        <div id="about" class="tab-content">
            <h2 style="margin: 0 0 20px; border-bottom: 1px solid #eee; padding-bottom: 10px;">Hakkımızda Sayfası</h2>
            <div class="form-group">
                <label>Başlık</label>
                <input type="text" name="about_title" class="form-control" value="<?php echo htmlspecialchars($settings['about_title']); ?>">
            </div>
            <div class="form-group">
                <label>Ana Metin</label>
                <textarea name="about_text" class="form-control" rows="6"><?php echo htmlspecialchars($settings['about_text']); ?></textarea>
            </div>
            <div class="form-group">
                <label>Misyon</label>
                <textarea name="about_mission" class="form-control" rows="3"><?php echo htmlspecialchars($settings['about_mission']); ?></textarea>
            </div>
            <div class="form-group">
                <label>Vizyon</label>
                <textarea name="about_vision" class="form-control" rows="3"><?php echo htmlspecialchars($settings['about_vision']); ?></textarea>
            </div>
            <div class="form-group">
                <label>Görsel Yükle</label>
                <input type="file" name="about_image_file" class="form-control">
            </div>
            <div class="form-group">
                <label>Görsel URL (veya mevcut)</label>
                <input type="text" name="about_image_url" class="form-control" value="<?php echo htmlspecialchars($settings['about_image_url']); ?>">
                <?php if (!empty($settings['about_image_url'])): ?>
                    <div style="margin-top: 10px;">
                        <img src="../<?php echo htmlspecialchars($settings['about_image_url']); ?>" style="max-width: 200px; border-radius: 4px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Contact Settings -->
        <div id="contact" class="tab-content">
            <h2 style="margin: 0 0 20px; border-bottom: 1px solid #eee; padding-bottom: 10px;">İletişim Bilgileri</h2>
            <div class="form-group">
                <label>Telefon 1 (WhatsApp için kullanılır)</label>
                <input type="text" name="contact_phone" class="form-control" value="<?php echo htmlspecialchars($settings['contact_phone']); ?>">
            </div>
            <div class="form-group">
                <label>Telefon 2 (İsteğe Bağlı)</label>
                <input type="text" name="contact_phone_2" class="form-control" value="<?php echo htmlspecialchars($settings['contact_phone_2'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label>E-posta</label>
                <input type="text" name="contact_email" class="form-control" value="<?php echo htmlspecialchars($settings['contact_email']); ?>">
            </div>
            <div class="form-group">
                <label>Adres</label>
                <textarea name="contact_address" class="form-control" rows="2"><?php echo htmlspecialchars($settings['contact_address']); ?></textarea>
            </div>
        </div>

        <!-- Social Settings -->
        <div id="social" class="tab-content">
            <h2 style="margin: 0 0 20px; border-bottom: 1px solid #eee; padding-bottom: 10px;">Sosyal Medya</h2>
            <div class="form-group">
                <label>Facebook URL</label>
                <input type="text" name="social_facebook" class="form-control" value="<?php echo htmlspecialchars($settings['social_facebook'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label>Instagram URL</label>
                <input type="text" name="social_instagram" class="form-control" value="<?php echo htmlspecialchars($settings['social_instagram'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label>Twitter (X) URL</label>
                <input type="text" name="social_twitter" class="form-control" value="<?php echo htmlspecialchars($settings['social_twitter'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label>LinkedIn URL</label>
                <input type="text" name="social_linkedin" class="form-control" value="<?php echo htmlspecialchars($settings['social_linkedin'] ?? ''); ?>">
            </div>
        </div>

        <!-- Footer Settings -->
        <div id="footer" class="tab-content">
            <h2 style="margin: 0 0 20px; border-bottom: 1px solid #eee; padding-bottom: 10px;">Footer (Alt Kısım)</h2>
            <div class="form-group">
                <label>Hakkımızda Kısa Yazı</label>
                <textarea name="footer_about" class="form-control" rows="3"><?php echo htmlspecialchars($settings['footer_about']); ?></textarea>
            </div>
        </div>

        <button type="submit" class="btn btn-primary" style="margin-top: 20px;">Ayarları Kaydet</button>
    </form>
</div>

<script>
function openTab(evt, tabName) {
    var i, tabcontent, tablinks;
    
    // Tüm tab içeriklerini gizle
    tabcontent = document.getElementsByClassName("tab-content");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
        tabcontent[i].classList.remove("active");
    }
    
    // Tüm tab butonlarından active sınıfını kaldır
    tablinks = document.getElementsByClassName("tab-btn");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    
    // Seçilen tabı göster ve butonu aktif yap
    document.getElementById(tabName).style.display = "block";
    document.getElementById(tabName).classList.add("active");
    evt.currentTarget.className += " active";
}
</script>

<?php include 'includes/footer.php'; ?>
