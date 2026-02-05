CREATE DATABASE IF NOT EXISTS healthy_life DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE healthy_life;

CREATE TABLE IF NOT EXISTS admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    description TEXT NOT NULL,
    icon VARCHAR(20) DEFAULT '🥗',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL,
    phone VARCHAR(50),
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO admin_users (name, email, password_hash)
VALUES ('Admin Kullanıcı', 'admin@saglikliyasam.com', '$2y$10$5p1Q7czQf8D2R0dEInbSIOXJkYo7oRww5.9sHVRokCVL8k4mR0AQy');

INSERT INTO services (title, description, icon)
VALUES
('Kişiye Özel Beslenme', 'Kan değerlerinize ve hedeflerinize göre kişiselleştirilmiş beslenme planı.', '🥗'),
('Yaşam Koçluğu', 'Stres, uyku ve hareket alışkanlıklarınızı dengeleyen bütüncül program.', '🌿'),
('Kurumsal Wellness', 'Şirketlere özel sağlıklı yaşam seminerleri ve atölyeleri.', '🏢');
