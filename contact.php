<?php require_once 'includes/db.php'; ?>
<?php
$message_sent = false;
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $subject = $_POST['subject'] ?? '';
    $message = $_POST['message'] ?? '';

    if ($name && $email && $message) {
        try {
            $stmt = $pdo->prepare("INSERT INTO messages (name, email, phone, subject, message) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$name, $email, $phone, $subject, $message]);
            $message_sent = true;
        } catch (PDOException $e) {
            $error_message = "Mesaj gönderilirken bir hata oluştu: " . $e->getMessage();
        }
    } else {
        $error_message = "Lütfen zorunlu alanları doldurunuz.";
    }
}
?>
<?php include 'includes/header.php'; ?>

<div class="container contact-section">
    <h1 style="text-align: center; margin-bottom: 30px;">İletişim</h1>

    <?php if ($message_sent): ?>
        <div style="background-color: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px; text-align: center;">
            Mesajınız başarıyla gönderildi. En kısa sürede size dönüş yapacağız.
        </div>
    <?php endif; ?>

    <?php if ($error_message): ?>
        <div style="background-color: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px; text-align: center;">
            <?php echo $error_message; ?>
        </div>
    <?php endif; ?>

    <div class="contact-wrapper">
        <div class="contact-info-card">
            <h3>İletişim Bilgileri</h3>
            <div class="info-item">
                <i class="fas fa-phone"></i>
                <span>
                    <?php echo htmlspecialchars($settings['contact_phone'] ?? '+90 555 123 45 67'); ?>
                    <?php if (!empty($settings['contact_phone_2'])): ?>
                        <br><?php echo htmlspecialchars($settings['contact_phone_2']); ?>
                    <?php endif; ?>
                </span>
            </div>
            <div class="info-item">
                <i class="fas fa-envelope"></i>
                <span><?php echo htmlspecialchars($settings['contact_email'] ?? 'info@tenteci.com'); ?></span>
            </div>
            <div class="info-item">
                <i class="fas fa-map-marker-alt"></i>
                <span><?php echo htmlspecialchars($settings['contact_address'] ?? 'İstanbul, Türkiye'); ?></span>
            </div>
        </div>

        <div class="contact-form-card">
            <form action="" method="POST">
                <div class="form-row">
                    <div class="form-group half">
                        <label for="name">Ad Soyad *</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="form-group half">
                        <label for="email">E-posta *</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="phone">Telefon</label>
                    <input type="tel" id="phone" name="phone">
                </div>
                <div class="form-group">
                    <label for="subject">Konu</label>
                    <input type="text" id="subject" name="subject">
                </div>
                <div class="form-group">
                    <label for="message">Mesajınız *</label>
                    <textarea id="message" name="message" required></textarea>
                </div>
                <button type="submit" class="btn btn-block">Gönder</button>
            </form>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
