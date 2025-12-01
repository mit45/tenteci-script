<?php require_once 'includes/db.php'; ?>
<?php include 'includes/header.php'; ?>

<div class="container" style="padding-top: 40px;">
    <h1 style="margin-bottom: 30px;">Ürünlerimiz</h1>
    
    <div class="products-grid">
        <?php
        try {
            $stmt = $pdo->query("SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id ORDER BY p.created_at DESC");
            while ($row = $stmt->fetch()) {
                // Resim URL'sini belirle
                $img_url = 'assets/images/default-product.jpg'; // Varsayılan resim
                
                if (!empty($row['image_url'])) {
                    // Eğer tam URL ise (http ile başlıyorsa) olduğu gibi kullan
                    if (strpos($row['image_url'], 'http') === 0) {
                        $img_url = $row['image_url'];
                    } else {
                        // Değilse yerel dosya yoludur
                        $img_url = $row['image_url'];
                    }
                } else {
                    // Resim yoksa isme göre demo resim ata
                    if (strpos($row['name'], 'Bioklimatik') !== false) {
                        $img_url = 'https://images.unsplash.com/photo-1632806689726-640d4729a69d?q=80&w=800&auto=format&fit=crop';
                    } elseif (strpos($row['name'], 'Mafsallı') !== false) {
                        $img_url = 'https://images.unsplash.com/photo-1615873968403-89e068629265?q=80&w=800&auto=format&fit=crop';
                    } elseif (strpos($row['name'], 'Zip') !== false) {
                        $img_url = 'https://images.unsplash.com/photo-1505691938895-1758d7feb511?q=80&w=800&auto=format&fit=crop';
                    } else {
                        $img_url = 'https://images.unsplash.com/photo-1596178060671-7a80dc8059ea?q=80&w=800&auto=format&fit=crop';
                    }
                }

                echo '<div class="product-card">';
                echo '<div class="product-image">';
                echo '<img src="' . $img_url . '" alt="' . htmlspecialchars($row['name']) . '">';
                echo '</div>';
                echo '<div class="product-info">';
                echo '<small style="color: #888;">' . htmlspecialchars($row['category_name']) . '</small>';
                echo '<h3>' . htmlspecialchars($row['name']) . '</h3>';
                echo '<p>' . htmlspecialchars($row['description']) . '</p>';
                echo '</div>';
                echo '</div>';
            }
        } catch (PDOException $e) {
            echo "Hata: " . $e->getMessage();
        }
        ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
