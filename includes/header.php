<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <?php
    // SEO Logic
    $seo_title = $page_title ?? ($settings['meta_title'] ?: ($settings['browser_title'] ?: ($settings['site_title'] ?? 'Seçici Tente&Branda')));
    $seo_description = $page_description ?? ($settings['meta_description'] ?: ($settings['hero_description'] ?? 'Seçici Tente & Branda - Modern gölgelendirme sistemleri.'));
    $seo_keywords = $page_keywords ?? ($settings['meta_keywords'] ?: 'tente, branda, pergola, gölgelendirme, kış bahçesi, otomatik tente, izmir tente, muğla tente, aydın tente, manisa tente, seçici tente');
    $seo_image = $page_image ?? ($settings['logo_url'] ?? 'assets/images/logo.png');
    $current_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    ?>

    <!-- SEO Meta Tags -->
    <meta name="description" content="<?php echo htmlspecialchars($seo_description); ?>">
    <meta name="keywords" content="<?php echo htmlspecialchars($seo_keywords); ?>">
    <meta name="author" content="Ümit Topuz">
    <meta name="robots" content="index, follow">
    <?php if (!empty($settings['google_verification'])): ?>
    <meta name="google-site-verification" content="<?php echo htmlspecialchars($settings['google_verification']); ?>" />
    <?php endif; ?>

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo $current_url; ?>">
    <meta property="og:title" content="<?php echo htmlspecialchars($seo_title); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($seo_description); ?>">
    <meta property="og:image" content="<?php echo htmlspecialchars($seo_image); ?>">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?php echo $current_url; ?>">
    <meta property="twitter:title" content="<?php echo htmlspecialchars($seo_title); ?>">
    <meta property="twitter:description" content="<?php echo htmlspecialchars($seo_description); ?>">
    <meta property="twitter:image" content="<?php echo htmlspecialchars($seo_image); ?>">

    <!-- JSON-LD Structured Data -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "LocalBusiness",
      "name": "<?php echo htmlspecialchars($settings['site_title'] ?? 'Seçici Tente&Branda'); ?>",
      "image": "<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/" . htmlspecialchars($settings['logo_url'] ?? 'assets/images/logo.png'); ?>",
      "telephone": "<?php echo htmlspecialchars($settings['contact_phone'] ?? ''); ?>",
      "email": "<?php echo htmlspecialchars($settings['contact_email'] ?? ''); ?>",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "<?php echo htmlspecialchars($settings['contact_address'] ?? ''); ?>",
        "addressLocality": "İzmir",
        "addressCountry": "TR"
      },
      "url": "<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]"; ?>",
      "priceRange": "₺₺"
    }
    </script>

    <title><?php echo htmlspecialchars($seo_title); ?></title>
    <link rel="icon" href="<?php echo htmlspecialchars($settings['favicon_url'] ?? 'assets/images/favicon.ico'); ?>" type="image/x-icon">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
</head>
<body>
    <header>
        <div class="container">
            <div class="site-title">
                <a href="anasayfa"><?php echo htmlspecialchars($settings['site_title'] ?? 'Seçici Tente&Branda'); ?></a>
            </div>
            <div class="logo">
                <a href="anasayfa"><img src="<?php echo htmlspecialchars($settings['logo_url'] ?? 'assets/images/logo.png'); ?>" alt="Logo" class="logo-img"></a>
            </div>
            
            <div class="header-right">
                <div class="header-social">
                    <?php if (!empty($settings['social_facebook'])): ?>
                        <a href="<?php echo htmlspecialchars($settings['social_facebook']); ?>" target="_blank"><i class="fab fa-facebook-f"></i></a>
                    <?php endif; ?>
                    <?php if (!empty($settings['social_instagram'])): ?>
                        <a href="<?php echo htmlspecialchars($settings['social_instagram']); ?>" target="_blank"><i class="fab fa-instagram"></i></a>
                    <?php endif; ?>
                    <?php if (!empty($settings['social_twitter'])): ?>
                        <a href="<?php echo htmlspecialchars($settings['social_twitter']); ?>" target="_blank"><i class="fab fa-twitter"></i></a>
                    <?php endif; ?>
                    <?php if (!empty($settings['social_linkedin'])): ?>
                        <a href="<?php echo htmlspecialchars($settings['social_linkedin']); ?>" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                    <?php endif; ?>
                </div>

                <nav>
                    <ul>
                        <li><a href="anasayfa">Ana Sayfa</a></li>
                        <li><a href="hakkimizda">Hakkımızda</a></li>
                        <li><a href="urunler">Ürünlerimiz</a></li>
                        <li><a href="iletisim">İletişim</a></li>
                    </ul>
                </nav>

                <div class="mobile-menu-btn">
                    <i class="fas fa-bars"></i>
                </div>
            </div>
        </div>
    </header>
    <main>
