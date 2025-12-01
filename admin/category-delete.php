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
        // Önce bu kategoriye ait ürünlerin kategori_id'sini NULL yap
        $stmt = $pdo->prepare("UPDATE products SET category_id = NULL WHERE category_id = ?");
        $stmt->execute([$id]);

        // Sonra kategoriyi sil
        $stmt = $pdo->prepare("DELETE FROM categories WHERE id = ?");
        $stmt->execute([$id]);
    } catch (PDOException $e) {
        // Hata olursa loglanabilir
    }
}

header('Location: /yonetim/kategoriler');
exit;
?>
