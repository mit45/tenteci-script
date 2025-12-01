    </main>
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Hakkımızda</h3>
                    <p><?php echo htmlspecialchars($settings['footer_about'] ?? 'Yılların tecrübesiyle tente, pergola ve gölgelendirme sistemlerinde kaliteli çözümler sunuyoruz.'); ?></p>
                    <div class="footer-social">
                        <?php if (!empty($settings['social_facebook'])): ?>
                            <a href="<?php echo htmlspecialchars($settings['social_facebook']); ?>" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        <?php endif; ?>
                        <?php if (!empty($settings['social_instagram'])): ?>
                            <a href="<?php echo htmlspecialchars($settings['social_instagram']); ?>" target="_blank"><i class="fab fa-instagram"></i></a>
                        <?php endif; ?>
                        <?php if (!empty($settings['social_twitter'])): ?>
                            <a href="<?php echo htmlspecialchars($settings['social_twitter']); ?>" target="_blank"><i class="fab fa-twitter"></i></a>
                        <?php endif; ?>
                        <?php if (!empty($settings['social_linkedin'])): ?>
                            <a href="<?php echo htmlspecialchars($settings['social_linkedin']); ?>" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="footer-section">
                    <h3>Hızlı Linkler</h3>
                    <ul>
                        <li><a href="anasayfa">Ana Sayfa</a></li>
                        <li><a href="urunler">Ürünler</a></li>
                        <li><a href="iletisim">İletişim</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>İletişim</h3>
                    <p>
                        <i class="fas fa-phone"></i> 
                        <?php echo htmlspecialchars($settings['contact_phone'] ?? '+90 555 123 45 67'); ?>
                        <?php if (!empty($settings['contact_phone_2'])): ?>
                             - <?php echo htmlspecialchars($settings['contact_phone_2']); ?>
                        <?php endif; ?>
                    </p>
                    <p><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($settings['contact_email'] ?? 'info@tenteci.com'); ?></p>
                    <p><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($settings['contact_address'] ?? 'İstanbul, Türkiye'); ?></p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> <?php echo htmlspecialchars($settings['site_title'] ?? 'Seçici Tente&Branda'); ?>. Tüm hakları saklıdır.</p>
            </div>
        </div>
    </footer>
    
    <!-- Cookie Consent Banner (Doğrudan Footer İçinde) -->
    <style>
        #cookie-consent-popup {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: #2c3e50;
            color: #fff;
            padding: 20px;
            display: flex; /* Varsayılan olarak görünür */
            justify-content: center;
            align-items: center;
            gap: 30px;
            box-shadow: 0 -5px 20px rgba(0,0,0,0.3);
            z-index: 999999;
            flex-wrap: wrap;
            text-align: center;
            border-top: 4px solid #e67e22;
            font-family: 'Poppins', sans-serif;
        }
        #cookie-consent-popup p {
            margin: 0;
            font-size: 14px;
            line-height: 1.6;
            max-width: 900px;
            color: #ecf0f1;
        }
        #cookie-consent-popup .cookie-btn-group {
            display: flex;
            gap: 15px;
        }
        #cookie-consent-popup button {
            padding: 10px 30px;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        #cookie-consent-popup .btn-accept {
            background-color: #e67e22;
            color: white;
            box-shadow: 0 4px 15px rgba(230, 126, 34, 0.3);
        }
        #cookie-consent-popup .btn-accept:hover {
            background-color: #d35400;
            transform: translateY(-2px);
        }
        #cookie-consent-popup .btn-reject {
            background-color: transparent;
            border: 2px solid #95a5a6 !important;
            color: #bdc3c7;
        }
        #cookie-consent-popup .btn-reject:hover {
            border-color: #ecf0f1 !important;
            color: #fff;
        }
        @media (max-width: 768px) {
            #cookie-consent-popup {
                flex-direction: column;
                gap: 20px;
                padding: 25px 20px;
            }
            #cookie-consent-popup .cookie-btn-group {
                width: 100%;
                justify-content: center;
            }
            #cookie-consent-popup button {
                flex: 1;
            }
        }
    </style>

    <div id="cookie-consent-popup">
        <p>
            Sizlere daha iyi hizmet sunabilmek, site trafiğini analiz etmek ve kişiselleştirilmiş içerik sunmak amacıyla sitemizde çerezler (cookies) kullanılmaktadır. 
            Siteyi kullanmaya devam ederek çerez kullanımını kabul etmiş olursunuz.
        </p>
        <div class="cookie-btn-group">
            <button class="btn-reject" onclick="closeCookieBanner(false)">Reddet</button>
            <button class="btn-accept" onclick="closeCookieBanner(true)">Kabul Et</button>
        </div>
    </div>

    <script>
        // Banner elementini seç
        var cookieBanner = document.getElementById('cookie-consent-popup');

        // Sayfa yüklendiğinde kontrol et
        document.addEventListener('DOMContentLoaded', function() {
            // Eğer daha önce tercih yapılmışsa banner'ı gizle
            if (localStorage.getItem('cookieChoice')) {
                cookieBanner.style.display = 'none';
            }
        });

        // Butonlara tıklanınca çalışacak fonksiyon
        function closeCookieBanner(accepted) {
            if (accepted) {
                localStorage.setItem('cookieChoice', 'accepted');
                console.log('Çerezler kabul edildi.');
            } else {
                localStorage.setItem('cookieChoice', 'rejected');
                console.log('Çerezler reddedildi.');
            }
            // Banner'ı kaldır
            cookieBanner.style.display = 'none';
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>
