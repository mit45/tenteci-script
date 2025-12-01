<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: /yonetim/giris');
    exit;
}
require_once '../includes/db.php';

$id = $_GET['id'] ?? 0;

if ($id) {
    try {
        $stmt = $pdo->prepare("DELETE FROM services WHERE id = ?");
        $stmt->execute([$id]);
    } catch (PDOException $e) {
        // Hata oluşursa loglanabilir
    }
}

header('Location: /yonetim/hizmetler');
exit;
?>
