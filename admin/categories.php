<?php include 'includes/header.php'; ?>

<div class="page-header">
    <h1 class="page-title">Kategoriler</h1>
    <a href="/yonetim/kategori-ekle" class="btn btn-primary"><i class="fas fa-plus"></i> Yeni Kategori Ekle</a>
</div>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Kategori Adı</th>
                <th>Slug (URL)</th>
                <th>İşlemler</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $stmt = $pdo->query("SELECT * FROM categories ORDER BY id DESC");
            while ($row = $stmt->fetch()) {
                echo '<tr>';
                echo '<td>' . $row['id'] . '</td>';
                echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                echo '<td>' . htmlspecialchars($row['slug']) . '</td>';
                echo '<td>
                        <a href="/yonetim/kategori-duzenle?id=' . $row['id'] . '" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Düzenle</a>
                        <a href="/yonetim/kategori-sil?id=' . $row['id'] . '" class="btn btn-danger btn-sm" onclick="return confirm(\'Bu kategoriyi silmek istediğinize emin misiniz?\')"><i class="fas fa-trash"></i> Sil</a>
                      </td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
</div>

<?php include 'includes/footer.php'; ?>
