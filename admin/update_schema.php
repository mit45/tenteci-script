<?php
require_once '../includes/db.php';

try {
    // Check if columns exist
    $columns = [
        'social_facebook' => 'VARCHAR(255)',
        'social_instagram' => 'VARCHAR(255)',
        'social_twitter' => 'VARCHAR(255)',
        'social_linkedin' => 'VARCHAR(255)',
        'meta_title' => 'VARCHAR(255)',
        'meta_description' => 'TEXT',
        'meta_keywords' => 'TEXT',
        'google_verification' => 'VARCHAR(255)'
    ];

    foreach ($columns as $column => $type) {
        try {
            $pdo->query("SELECT $column FROM site_settings LIMIT 1");
        } catch (PDOException $e) {
            // Column doesn't exist, add it
            $pdo->exec("ALTER TABLE site_settings ADD COLUMN $column $type DEFAULT ''");
            echo "Added column: $column<br>";
        }
    }

    // Varsayılan SEO Ayarlarını Doldur
    $default_title = "Seçici Tente & Branda | İzmir Tente ve Pergola Sistemleri";
    $default_desc = "İzmir'de profesyonel tente, pergola, kış bahçesi ve gölgelendirme sistemleri. Kaliteli malzeme, uygun fiyat ve uzman montaj hizmeti için hemen arayın.";
    $default_keys = "tente, pergola, branda, izmir tente, otomatik tente, kış bahçesi, gölgelendirme, bioklimatik pergola, mafsallı tente, körüklü tente, tente tamiri, branda değişimi";
    $default_google_verification = "Xmsag-7N_RERxnzOzM3Pw49aJIhfflN3RtwWbUYtbTI";

    $sql = "UPDATE site_settings SET 
            meta_title = CASE WHEN meta_title = '' OR meta_title IS NULL THEN :title ELSE meta_title END,
            meta_description = CASE WHEN meta_description = '' OR meta_description IS NULL THEN :desc ELSE meta_description END,
            meta_keywords = CASE WHEN meta_keywords = '' OR meta_keywords IS NULL THEN :keys ELSE meta_keywords END,
            google_verification = CASE WHEN google_verification = '' OR google_verification IS NULL THEN :google ELSE google_verification END
            WHERE id = 1";
            
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':title' => $default_title,
        ':desc' => $default_desc,
        ':keys' => $default_keys,
        ':google' => $default_google_verification
    ]);
    
    if ($stmt->rowCount() > 0) {
        echo "SEO ayarları varsayılan değerlerle güncellendi.<br>";
    } else {
        echo "SEO ayarları zaten dolu veya değişiklik yapılmadı.<br>";
    }
    
    echo "Schema update completed successfully.";
    
} catch (PDOException $e) {
    echo "Error updating schema: " . $e->getMessage();
}
?>