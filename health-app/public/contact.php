<?php
require __DIR__ . '/../config/database.php';

$successMessage = null;
$errorMessage = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($name === '' || $email === '' || $message === '') {
        $errorMessage = 'Lütfen ad, e-posta ve mesaj alanlarını doldurun.';
    } else {
        $statement = $pdo->prepare('INSERT INTO contact_messages (name, email, phone, message) VALUES (:name, :email, :phone, :message)');
        $statement->execute([
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'message' => $message,
        ]);
        $successMessage = 'Mesajınız başarıyla iletildi. En kısa sürede dönüş yapacağız.';
    }
}

include __DIR__ . '/partials/header.php';
?>
<div class="container">
    <div class="row g-4">
        <div class="col-lg-6">
            <h1 class="section-title">İletişim</h1>
            <p class="text-muted">Danışmanlık almak, programlarımız hakkında bilgi edinmek veya randevu oluşturmak için bize ulaşabilirsiniz.</p>
            <div class="card card-glass p-4">
                <h5 class="section-title">İletişim Bilgileri</h5>
                <p class="mb-1">📍 Bağdat Caddesi No:88, Kadıköy / İstanbul</p>
                <p class="mb-1">📞 +90 (212) 555 22 11</p>
                <p class="mb-1">✉️ info@saglikliyasam.com</p>
                <p class="text-muted mt-3">Hafta içi 09:00 - 18:00 saatleri arasında hizmet vermekteyiz.</p>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card card-glass p-4">
                <h5 class="section-title">Bize Yazın</h5>
                <?php if ($successMessage) : ?>
                    <div class="alert alert-success"> <?php echo htmlspecialchars($successMessage); ?> </div>
                <?php endif; ?>
                <?php if ($errorMessage) : ?>
                    <div class="alert alert-danger"> <?php echo htmlspecialchars($errorMessage); ?> </div>
                <?php endif; ?>
                <form method="post">
                    <div class="mb-3">
                        <label class="form-label">Ad Soyad</label>
                        <input class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">E-posta</label>
                        <input class="form-control" type="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Telefon</label>
                        <input class="form-control" name="phone">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mesaj</label>
                        <textarea class="form-control" name="message" rows="4" required></textarea>
                    </div>
                    <button class="btn btn-success" type="submit">Gönder</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include __DIR__ . '/partials/footer.php'; ?>
