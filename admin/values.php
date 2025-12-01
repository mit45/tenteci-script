<?php include 'includes/header.php'; ?>

<?php
// Tablo kontrolü ve oluşturma
try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS company_values (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        description TEXT,
        icon VARCHAR(50) DEFAULT 'fas fa-check',
        display_order INT DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    
    // Varsayılan veri kontrolü
    $stmt = $pdo->query("SELECT COUNT(*) FROM company_values");
    if ($stmt->fetchColumn() == 0) {
        $pdo->exec("INSERT INTO company_values (title, description, icon, display_order) VALUES 
            ('Kalite', 'En dayanıklı malzemeleri kullanarak uzun ömürlü ürünler sunuyoruz.', 'fas fa-check-circle', 1),
            ('Güven', 'Söz verdiğimiz zamanda teslimat ve satış sonrası destek garantisi.', 'fas fa-smile', 2),
            ('Tasarım', 'Mekanınıza özel, estetik ve modern tasarım çözümleri.', 'fas fa-pencil-ruler', 3)
        ");
    }
} catch (PDOException $e) {
    // Tablo zaten varsa veya başka hata varsa devam et
}
?>

<div class="page-header">
    <h1 class="page-title">Değerlerimiz</h1>
    <a href="/yonetim/deger-ekle" class="btn btn-primary"><i class="fas fa-plus"></i> Yeni Değer Ekle</a>
</div>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>Sıra</th>
                <th>İkon</th>
                <th>Başlık</th>
                <th>Açıklama</th>
                <th>İşlemler</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $stmt = $pdo->query("SELECT * FROM company_values ORDER BY display_order ASC");
            while ($row = $stmt->fetch()) {
                echo '<tr>';
                echo '<td>' . $row['display_order'] . '</td>';
                echo '<td><i class="' . htmlspecialchars($row['icon']) . '" style="font-size: 24px; color: #e67e22;"></i></td>';
                echo '<td>' . htmlspecialchars($row['title']) . '</td>';
                echo '<td>' . htmlspecialchars(mb_substr($row['description'], 0, 50)) . '...</td>';
                echo '<td>
                        <a href="/yonetim/deger-duzenle?id=' . $row['id'] . '" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Düzenle</a>
                        <a href="/yonetim/deger-sil?id=' . $row['id'] . '" class="btn btn-danger btn-sm" onclick="return confirm(\'Silmek istediğinize emin misiniz?\')"><i class="fas fa-trash"></i> Sil</a>
                      </td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
</div>

<?php include 'includes/footer.php'; ?>
