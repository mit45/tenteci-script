<?php require_once 'includes/db.php'; ?>
<?php include 'includes/header.php'; ?>

<section class="hero" style="<?php echo isset($settings['hero_image_url']) ? 'background-image: url(\'' . htmlspecialchars($settings['hero_image_url']) . '\');' : 'background-image: url(\'https://ersagolgelendirme.com/wp-content/uploads/2024/01/slider-1.jpg\');'; ?>">
    <div class="container">
        <div class="hero-content">
            <h2><?php echo htmlspecialchars($settings['hero_title'] ?? 'Modern Gölgelendirme Sistemleri'); ?></h2>
            <p><?php echo htmlspecialchars($settings['hero_description'] ?? 'Estetik ve fonksiyonel çözümlerle yaşam alanlarınıza değer katıyoruz.'); ?></p>
            
            <?php 
            $phone_clean = preg_replace('/[^0-9]/', '', $settings['contact_phone'] ?? '');
            ?>
            <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
                <a href="tel:<?php echo $phone_clean; ?>" class="btn"><i class="fas fa-phone-alt"></i> Hemen Arayın</a>
                <a href="https://wa.me/<?php echo $phone_clean; ?>" class="btn" style="background-color: #25D366; border-color: #25D366;" target="_blank"><i class="fab fa-whatsapp"></i> WhatsApp</a>
            </div>
        </div>
    </div>
</section>

<!-- Hizmetlerimiz Slider Section -->
<section id="hizmetlerimiz" class="services-slider-section" style="padding: 40px 0; background-color: #fff;">
    <div class="container">
        <div style="text-align: center; margin-bottom: 30px;">
            <h2 style="font-size: 1.8rem; color: #333;">Hizmetlerimiz</h2>
            <div style="width: 50px; height: 3px; background: #e67e22; margin: 10px auto;"></div>
        </div>
    </div>
    
    <div class="container">
        <div class="swiper servicesSwiper">
            <div class="swiper-wrapper">
                <?php
                try {
                    // Check if services table exists first to avoid errors if setup wasn't run
                    $tableExists = $pdo->query("SHOW TABLES LIKE 'services'")->rowCount() > 0;
                    
                    if ($tableExists) {
                        $stmt = $pdo->query("SELECT * FROM services ORDER BY display_order ASC");
                        while ($row = $stmt->fetch()) {
                            $img_url = $row['image_url'];
                            if (empty($img_url)) {
                                $img_url = 'assets/images/default-service.jpg';
                            }
                            
                            echo '<div class="swiper-slide">';
                            echo '<div class="service-slide-item" style="position: relative; overflow: hidden; border-radius: 8px; height: 150px;">';
                            echo '<img src="' . htmlspecialchars($img_url) . '" alt="' . htmlspecialchars($row['name']) . '" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s;">';
                            echo '<div class="service-overlay" style="position: absolute; bottom: 0; left: 0; right: 0; background: rgba(0,0,0,0.6); color: #fff; padding: 8px; text-align: center;">';
                            echo '<h3 style="font-size: 14px; margin: 0; font-weight: 500;">' . htmlspecialchars($row['name']) . '</h3>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo '<div class="swiper-slide"><p style="text-align:center;">Hizmetler yüklenemedi.</p></div>';
                    }
                } catch (PDOException $e) {
                    echo "Hata: " . $e->getMessage();
                }
                ?>
            </div>
            <!-- Add Pagination -->
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var swiper = new Swiper(".servicesSwiper", {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: true,
            centerInsufficientSlides: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                768: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                },
                1024: {
                    slidesPerView: 4,
                    spaceBetween: 30,
                },
                1280: {
                    slidesPerView: 5,
                    spaceBetween: 30,
                },
            },
        });
    });
</script>

<section class="container" style="padding: 60px 20px;">
    <div style="text-align: center; margin-bottom: 50px;">
        <h2>Ürünlerimiz</h2>
        <div style="width: 60px; height: 3px; background: #e67e22; margin: 15px auto;"></div>
        <p style="color: #777; max-width: 700px; margin: 0 auto;">Her mekana uygun, kaliteli ve uzun ömürlü tente ve gölgelendirme sistemleri.</p>
    </div>

    <div class="products-grid">
        <?php
        try {
            $stmt = $pdo->query("SELECT * FROM products ORDER BY id ASC");
            while ($row = $stmt->fetch()) {
                // Resim URL'sini belirle
                $img_url = 'assets/images/default-product.jpg'; // Varsayılan resim
                
                if (!empty($row['image_url'])) {
                    $img_url = $row['image_url'];
                }

                echo '<div class="product-card">';
                echo '<div class="product-image">';
                echo '<img src="' . htmlspecialchars($img_url) . '" alt="' . htmlspecialchars($row['name']) . '">';
                echo '</div>';
                echo '<div class="product-info">';
                echo '<h3>' . htmlspecialchars($row['name']) . '</h3>';
                echo '<p>' . htmlspecialchars($row['description']) . '</p>';
                echo '<a href="urunler" style="color: #e67e22; font-weight: 600; font-size: 14px;">İncele &rarr;</a>';
                echo '</div>';
                echo '</div>';
            }
        } catch (PDOException $e) {
            echo "Hata: " . $e->getMessage();
        }
        ?>
    </div>
</section>

<section style="background-color: #f9f9f9; padding: 80px 0;">
    <div class="container">
        <div style="display: flex; flex-wrap: wrap; align-items: center; gap: 50px;">
            <div style="flex: 1; min-width: 300px;">
                <h2 style="margin-bottom: 20px;"><?php echo htmlspecialchars($settings['home_about_title'] ?? 'Hakkımızda'); ?></h2>
                <div style="width: 60px; height: 3px; background: #e67e22; margin-bottom: 25px;"></div>
                <div style="margin-bottom: 30px; color: #555; line-height: 1.6;">
                    <?php echo nl2br(htmlspecialchars($settings['home_about_text'] ?? 'Sektördeki tecrübemiz ve uzman kadromuz ile tente ve gölgelendirme sistemleri konusunda profesyonel çözümler sunuyoruz. Müşteri memnuniyetini ön planda tutarak, kaliteli malzeme ve titiz işçilikle projelerinizi hayata geçiriyoruz.')); ?>
                </div>
                <a href="hakkimizda" class="btn">Devamını Oku</a>
            </div>
            <div style="flex: 1; min-width: 300px;">
                <img src="<?php echo htmlspecialchars($settings['home_about_image_url'] ?? 'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?q=80&w=800&auto=format&fit=crop'); ?>" alt="Hakkımızda" style="width: 100%; border-radius: 8px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            </div>
        </div>
    </div>
</section>

<section class="container" style="padding: 80px 20px;">
    <div style="text-align: center; margin-bottom: 50px;">
        <h2 style="font-size: 2rem; color: #2c3e50; margin-bottom: 10px;">Tüm Ege Bölgesi'nde Hizmet Veriyoruz</h2>
        <p style="color: #7f8c8d; font-size: 1.1rem;">Başlıca Hizmet Bölgelerimiz</p>
    </div>

    <div class="service-areas-grid">
        <?php
        try {
            $stmt = $pdo->query("SELECT * FROM service_areas ORDER BY display_order ASC");
            while ($row = $stmt->fetch()) {
                $img_url = $row['image_url'];
                if (empty($img_url)) {
                    $img_url = 'assets/images/default-city.jpg';
                }
                
                echo '<div class="service-area-card">';
                echo '<div class="area-image">';
                echo '<img src="' . htmlspecialchars($img_url) . '" alt="' . htmlspecialchars($row['name']) . '">';
                echo '</div>';
                echo '<div class="area-info">';
                echo '<h3>' . htmlspecialchars($row['name']) . '</h3>';
                echo '<a href="iletisim" class="area-link">Görüntüle</a>';
                echo '<div class="area-line"></div>';
                echo '</div>';
                echo '</div>';
            }
        } catch (PDOException $e) {
            echo "Hata: " . $e->getMessage();
        }
        ?>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
