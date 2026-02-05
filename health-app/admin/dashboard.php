<?php
require __DIR__ . '/../config/database.php';
include __DIR__ . '/includes/header.php';

$serviceCount = $pdo->query('SELECT COUNT(*) as total FROM services')->fetch();
$messageCount = $pdo->query('SELECT COUNT(*) as total FROM contact_messages')->fetch();
$patientCount = $pdo->query('SELECT COUNT(*) as total FROM patients')->fetch();
$appointmentCount = $pdo->query('SELECT COUNT(*) as total FROM appointments')->fetch();
?>
<div class="row g-4">
    <div class="col-md-3">
        <div class="card card-glass p-4">
            <h5 class="section-title">Hoş geldiniz</h5>
            <p class="text-muted mb-0">Merhaba, <?php echo htmlspecialchars($_SESSION['admin_name'] ?? 'Yönetici'); ?>!</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-glass p-4">
            <h5 class="section-title">Hizmet Sayısı</h5>
            <p class="display-6 mb-0"><?php echo (int) ($serviceCount['total'] ?? 0); ?></p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-glass p-4">
            <h5 class="section-title">İletişim Mesajları</h5>
            <p class="display-6 mb-0"><?php echo (int) ($messageCount['total'] ?? 0); ?></p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-glass p-4">
            <h5 class="section-title">Danışan Sayısı</h5>
            <p class="display-6 mb-0"><?php echo (int) ($patientCount['total'] ?? 0); ?></p>
        </div>
    </div>
</div>

<div class="card card-glass p-4 mt-4">
    <h4 class="section-title">Hızlı İşlemler</h4>
    <div class="d-flex flex-wrap gap-3 mt-3">
        <a class="btn btn-success" href="services.php">Hizmetleri Yönet</a>
        <a class="btn btn-outline-success" href="patients.php">Danışanları Yönet</a>
        <a class="btn btn-outline-success" href="appointments.php">Randevuları Yönet</a>
        <a class="btn btn-outline-success" href="messages.php">Mesajları Görüntüle</a>
    </div>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
