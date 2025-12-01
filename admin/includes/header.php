<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: /yonetim/giris');
    exit;
}
require_once '../includes/db.php';
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Paneli - Seçici Tente&Branda</title>
    <link rel="stylesheet" href="/admin/assets/css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="admin-wrapper">
        <!-- Sidebar -->
        <nav class="sidebar">
            <div class="sidebar-header">
                <h2>Seçici Tente</h2>
            </div>
            <ul class="sidebar-menu">
                <li><a href="/yonetim" class="<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>"><i class="fas fa-home"></i> <span>Ana Sayfa</span></a></li>
                <li><a href="/yonetim/kategoriler" class="<?php echo basename($_SERVER['PHP_SELF']) == 'categories.php' ? 'active' : ''; ?>"><i class="fas fa-tags"></i> <span>Kategoriler</span></a></li>
                <li><a href="/yonetim/urunler" class="<?php echo basename($_SERVER['PHP_SELF']) == 'products.php' ? 'active' : ''; ?>"><i class="fas fa-box"></i> <span>Ürünler</span></a></li>
                <li><a href="/yonetim/hizmetler" class="<?php echo basename($_SERVER['PHP_SELF']) == 'services.php' ? 'active' : ''; ?>"><i class="fas fa-tools"></i> <span>Hizmetlerimiz</span></a></li>
                <li><a href="/yonetim/hizmet-bolgeleri" class="<?php echo basename($_SERVER['PHP_SELF']) == 'service-areas.php' ? 'active' : ''; ?>"><i class="fas fa-map-marker-alt"></i> <span>Hizmet Bölgeleri</span></a></li>
                <li><a href="/yonetim/degerler" class="<?php echo basename($_SERVER['PHP_SELF']) == 'values.php' ? 'active' : ''; ?>"><i class="fas fa-star"></i> <span>Değerlerimiz</span></a></li>
                <li><a href="/yonetim/mesajlar" class="<?php echo basename($_SERVER['PHP_SELF']) == 'messages.php' ? 'active' : ''; ?>"><i class="fas fa-envelope"></i> <span>Mesajlar</span></a></li>
                <li><a href="/yonetim/ayarlar" class="<?php echo basename($_SERVER['PHP_SELF']) == 'settings.php' ? 'active' : ''; ?>"><i class="fas fa-cog"></i> <span>Site Ayarları</span></a></li>
                <li><a href="/yonetim/profil" class="<?php echo basename($_SERVER['PHP_SELF']) == 'profile.php' ? 'active' : ''; ?>"><i class="fas fa-user-cog"></i> <span>Profil / Şifre</span></a></li>
                <li><a href="/anasayfa" target="_blank"><i class="fas fa-external-link-alt"></i> <span>Siteyi Görüntüle</span></a></li>
                <li><a href="/yonetim/cikis"><i class="fas fa-sign-out-alt"></i> <span>Çıkış Yap</span></a></li>
            </ul>
        </nav>

        <!-- Main Content -->
        <div class="main-content">
            <header class="top-header">
                <div class="sidebar-toggle" id="sidebarToggle" style="cursor: pointer; font-size: 20px; color: #2c3e50; margin-right: 20px;">
                    <i class="fas fa-bars"></i>
                </div>
                <div class="user-info">
                    <span>Hoşgeldin, <strong><?php echo htmlspecialchars($_SESSION['admin_username']); ?></strong></span>
                </div>
            </header>
            <div class="content">
