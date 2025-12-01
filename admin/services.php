<?php include 'includes/header.php'; ?>

<div class="page-header">
    <h1 class="page-title">Hizmetlerimiz</h1>
    <a href="/yonetim/hizmet-ekle" class="btn btn-primary"><i class="fas fa-plus"></i> Yeni Hizmet Ekle</a>
</div>

<div class="card">
    <div style="overflow-x: auto;">
        <table class="table">
            <thead>
                <tr>
                    <th width="100">Görsel</th>
                    <th>Hizmet Adı</th>
                    <th>Sıra</th>
                    <th width="150">İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stmt = $pdo->query("SELECT * FROM services ORDER BY display_order ASC");
                while ($row = $stmt->fetch()) {
                    echo '<tr>';
                    echo '<td>';
                    if ($row['image_url']) {
                        // Check if it's an external URL or local file
                        $img_src = (strpos($row['image_url'], 'http') === 0) ? $row['image_url'] : '../' . $row['image_url'];
                        echo '<img src="' . htmlspecialchars($img_src) . '" style="width: 60px; height: 40px; object-fit: cover; border-radius: 4px;">';
                    }
                    echo '</td>';
                    echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['display_order']) . '</td>';
                    echo '<td>
                            <a href="/yonetim/hizmet-duzenle?id=' . $row['id'] . '" class="btn btn-sm btn-edit action-btn"><i class="fas fa-edit"></i></a>
                            <a href="/yonetim/hizmet-sil?id=' . $row['id'] . '" class="btn btn-sm btn-delete action-btn" onclick="return confirm(\'Silmek istediğinize emin misiniz?\')"><i class="fas fa-trash"></i></a>
                          </td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
