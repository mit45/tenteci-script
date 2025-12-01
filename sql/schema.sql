-- CREATE DATABASE IF NOT EXISTS tente_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- USE tente_db;

CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT,
    name VARCHAR(200) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2),
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

CREATE TABLE IF NOT EXISTS messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    subject VARCHAR(200),
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Örnek Veriler
INSERT INTO categories (name, slug, description) VALUES 
('Pergola Sistemleri', 'pergola-sistemleri', 'Otomatik ve manuel pergola sistemleri'),
('Tente Sistemleri', 'tente-sistemleri', 'Mafsallı, kasetli ve körüklü tente modelleri'),
('Gölgelendirme', 'golgelendirme', 'Dış mekan gölgelendirme çözümleri');

INSERT INTO products (category_id, name, description, price, image_url) VALUES 
(1, 'Bioklimatik Pergola', 'Alüminyum panelli, tam otomatik bioklimatik pergola sistemi.', 25000.00, 'assets/images/bioklimatik.jpg'),
(2, 'Mafsallı Tente', 'Ekonomik ve kullanışlı mafsallı tente sistemi.', 5000.00, 'assets/images/mafsalli.jpg'),
(3, 'Zip Perde', 'Rüzgara dayanıklı dış mekan zip perde sistemi.', 3000.00, 'assets/images/zip-perde.jpg');
