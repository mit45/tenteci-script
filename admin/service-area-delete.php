<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: /yonetim/giris');
    exit;
}
require_once '../includes/db.php';

$id = $_GET['id'] ?? null;

if ($id) {
    try {
        $stmt = $pdo->prepare("DELETE FROM service_areas WHERE id = ?");
        $stmt->execute([$id]);
    } catch (PDOException $e) {
        // Hata oluşursa loglanabilir
    }
}

header('Location: /yonetim/hizmet-bolgeleri');
exit;
?>