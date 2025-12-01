<?php
require_once '../includes/db.php';

try {
    // Check if columns exist
    $columns = [
        'social_facebook' => 'VARCHAR(255)',
        'social_instagram' => 'VARCHAR(255)',
        'social_twitter' => 'VARCHAR(255)',
        'social_linkedin' => 'VARCHAR(255)'
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
    
    echo "Schema update completed successfully.";
    
} catch (PDOException $e) {
    echo "Error updating schema: " . $e->getMessage();
}
?>