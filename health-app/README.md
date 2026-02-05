# Sağlıklı Yaşam Danışmanlık Merkezi Web Uygulaması

Bu örnek uygulama PHP, PDO ve MySQL kullanarak hazırlanmış, Bootstrap 5 uyumlu modern bir web arayüzü ve basit bir admin paneli içerir.

## Kurulum

1. `health-app/database.sql` dosyasını MySQL'e aktarın.
2. `health-app/config/config.php` dosyasındaki veritabanı bilgilerini güncelleyin.
3. Proje kökünü sunucunuzun web dizinine kopyalayın.
4. Tarayıcıdan `health-app/public/index.php` adresini açın.

## Admin Panel

- Giriş sayfası: `health-app/admin/login.php`
- Varsayılan hesap: `admin@saglikliyasam.com`
- Şifre hash'i `database.sql` içinde bulunmaktadır. Kendi şifrenizi aşağıdaki komutla oluşturabilirsiniz:

```bash
php -r "echo password_hash('Sifre123', PASSWORD_DEFAULT);"
```

## Özellikler

- Anasayfa, hizmetler, hakkımızda ve iletişim sayfaları
- İletişim formu (PDO ile kayıt)
- Admin panel üzerinden hizmet ekleme/silme
- Gelen mesajları görüntüleme
- Danışan kayıt, düzenleme, silme ve durum takibi
- Randevu planlama, düzenleme, silme ve durum takibi
