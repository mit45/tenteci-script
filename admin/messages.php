<?php include 'includes/header.php'; ?>

<div class="page-header">
    <h1 class="page-title">Gelen Mesajlar</h1>
</div>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th class="mobile-hide">Tarih</th>
                <th>Ad Soyad</th>
                <th class="mobile-hide">E-posta</th>
                <th class="mobile-hide">Telefon</th>
                <th>Konu</th>
                <th>Mesaj</th>
                <th>İşlemler</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $stmt = $pdo->query("SELECT * FROM messages ORDER BY created_at DESC");
            while ($row = $stmt->fetch()) {
                echo '<tr>';
                echo '<td class="mobile-hide" style="white-space: nowrap;">' . date('d.m.Y H:i', strtotime($row['created_at'])) . '</td>';
                echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                echo '<td class="mobile-hide"><a href="mailto:' . htmlspecialchars($row['email']) . '">' . htmlspecialchars($row['email']) . '</a></td>';
                echo '<td class="mobile-hide">' . htmlspecialchars($row['phone']) . '</td>';
                echo '<td>' . htmlspecialchars($row['subject']) . '</td>';
                echo '<td>' . nl2br(htmlspecialchars($row['message'])) . '</td>';
                echo '<td style="white-space: nowrap;">
                        <a href="mailto:' . htmlspecialchars($row['email']) . '?subject=Re: ' . htmlspecialchars($row['subject']) . '" class="btn action-btn edit-btn" title="Cevapla"><i class="fas fa-reply"></i> <span>Cevapla</span></a>
                        <a href="/yonetim/mesaj-sil?id=' . $row['id'] . '" class="btn action-btn delete-btn" onclick="return confirm(\'Bu mesajı silmek istediğinize emin misiniz?\')" title="Sil"><i class="fas fa-trash"></i> <span>Sil</span></a>
                      </td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
</div>

<?php include 'includes/footer.php'; ?>
