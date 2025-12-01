<?php include 'includes/header.php'; ?>

<div class="page-header">
    <h1 class="page-title">Ürün Yönetimi</h1>
    <a href="/yonetim/urun-ekle" class="btn btn-primary"><i class="fas fa-plus"></i> Yeni Ürün Ekle</a>
</div>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>Resim</th>
                <th>Ürün Adı</th>
                <th class="mobile-hide">Kategori</th>
                <th>İşlemler</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $stmt = $pdo->query("SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id ORDER BY p.created_at DESC");
            while ($row = $stmt->fetch()) {
                echo '<tr>';
                echo '<td>';
                if ($row['image_url']) {
                    // Eğer tam URL ise (unsplash gibi) direkt göster, değilse path ekle
                    $img_src = (strpos($row['image_url'], 'http') === 0) ? $row['image_url'] : '/' . $row['image_url'];
                    echo '<img src="' . htmlspecialchars($img_src) . '" alt="" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">';
                } else {
                    echo '<i class="fas fa-image" style="font-size: 24px; color: #ccc;"></i>';
                }
                echo '</td>';
                echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                echo '<td class="mobile-hide">' . htmlspecialchars($row['category_name']) . '</td>';
                echo '<td>
                        <a href="/yonetim/urun-duzenle?id=' . $row['id'] . '" class="btn action-btn edit-btn" title="Düzenle"><i class="fas fa-edit"></i> <span>Düzenle</span></a>
                        <a href="/admin/product-delete.php?id=' . $row['id'] . '" class="btn action-btn delete-btn" onclick="return confirm(\'Bu ürünü silmek istediğinize emin misiniz?\')" title="Sil"><i class="fas fa-trash"></i> <span>Sil</span></a>
                      </td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
</div>

<?php include 'includes/footer.php'; ?>
