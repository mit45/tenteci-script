<?php require_once 'includes/db.php'; ?>
<?php
$page_title = ($settings['about_title'] ?? 'Hakkımızda') . " - " . ($settings['site_title'] ?? 'Seçici Tente');
$page_description = "Seçici Tente & Branda hakkında detaylı bilgi, misyonumuz ve vizyonumuz.";
?>
<?php include 'includes/header.php'; ?>

<div class="container" style="padding-top: 40px; padding-bottom: 60px;">
    <div class="about-content" style="display: flex; gap: 40px; align-items: center; flex-wrap: wrap;">
        <div class="about-text" style="flex: 1; min-width: 300px;">
            <h1 style="margin-bottom: 20px; color: #2c3e50;"><?php echo htmlspecialchars($settings['about_title'] ?? 'Hakkımızda'); ?></h1>
            <div style="margin-bottom: 15px; color: #555; line-height: 1.8;">
                <?php echo nl2br(htmlspecialchars($settings['about_text'] ?? 'Seçici Tente & Branda olarak, yılların verdiği tecrübe ve birikimle dış mekan gölgelendirme sistemleri sektöründe hizmet vermekteyiz. Müşteri memnuniyetini her zaman ön planda tutan firmamız, estetik ve fonksiyonelliği bir araya getiren çözümler sunmaktadır.

Urla ve çevresinde başladığımız yolculuğumuzda, bugün modern pergola sistemleri, bioklimatik tavanlar, mafsallı tenteler ve zip perde sistemleri gibi geniş bir ürün yelpazesi ile mekanlarınıza değer katıyoruz.')); ?>
            </div>
            
            <?php 
            $mission = $settings['about_mission'] ?? 'Kaliteli malzeme ve uzman işçilikle, müşterilerimizin ihtiyaçlarına en uygun, uzun ömürlü ve şık gölgelendirme çözümleri üretmek.';
            if (!empty($mission)): 
            ?>
            <h3 style="margin-top: 25px; margin-bottom: 10px; color: #e67e22;">Misyonumuz</h3>
            <p style="margin-bottom: 15px; color: #555;">
                <?php echo nl2br(htmlspecialchars($mission)); ?>
            </p>
            <?php endif; ?>

            <?php 
            $vision = $settings['about_vision'] ?? 'Sektördeki teknolojik gelişmeleri yakından takip ederek, yenilikçi tasarımlarla bölgenin lider gölgelendirme sistemleri firması olmak.';
            if (!empty($vision)): 
            ?>
            <h3 style="margin-top: 25px; margin-bottom: 10px; color: #e67e22;">Vizyonumuz</h3>
            <p style="color: #555;">
                <?php echo nl2br(htmlspecialchars($vision)); ?>
            </p>
            <?php endif; ?>
        </div>
        <div class="about-image" style="flex: 1; min-width: 300px;">
            <img src="<?php echo htmlspecialchars($settings['about_image_url'] ?? 'https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&w=800&auto=format&fit=crop'); ?>" alt="Hakkımızda" style="width: 100%; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
        </div>
    </div>
</div>

<section style="background-color: #f9f9f9; padding: 60px 0;">
    <div class="container">
        <h2 style="text-align: center; margin-bottom: 40px; color: #2c3e50;">Değerlerimiz</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 30px;">
            <?php
            try {
                // Tablo var mı kontrol et
                $tableExists = $pdo->query("SHOW TABLES LIKE 'company_values'")->rowCount() > 0;
                
                if ($tableExists) {
                    $stmt = $pdo->query("SELECT * FROM company_values ORDER BY display_order ASC");
                    while ($row = $stmt->fetch()) {
                        echo '<div style="background: #fff; padding: 30px; border-radius: 10px; text-align: center; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">';
                        echo '<i class="' . htmlspecialchars($row['icon']) . '" style="font-size: 40px; color: #e67e22; margin-bottom: 20px;"></i>';
                        echo '<h3 style="margin-bottom: 15px;">' . htmlspecialchars($row['title']) . '</h3>';
                        echo '<p style="color: #666;">' . htmlspecialchars($row['description']) . '</p>';
                        echo '</div>';
                    }
                } else {
                    // Tablo yoksa varsayılanları göster (Fallback)
                    echo '<div style="background: #fff; padding: 30px; border-radius: 10px; text-align: center; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">';
                    echo '<i class="fas fa-check-circle" style="font-size: 40px; color: #e67e22; margin-bottom: 20px;"></i>';
                    echo '<h3 style="margin-bottom: 15px;">Kalite</h3>';
                    echo '<p style="color: #666;">En dayanıklı malzemeleri kullanarak uzun ömürlü ürünler sunuyoruz.</p>';
                    echo '</div>';
                }
            } catch (PDOException $e) {
                echo "Hata: " . $e->getMessage();
            }
            ?>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
