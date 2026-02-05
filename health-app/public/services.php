<?php
require __DIR__ . '/../config/database.php';
$services = $pdo->query('SELECT id, title, description, icon FROM services ORDER BY id DESC')->fetchAll();
include __DIR__ . '/partials/header.php';
?>
<div class="container">
    <h1 class="section-title mb-4">Hizmetlerimiz</h1>
    <div class="row g-4">
        <?php foreach ($services as $service) : ?>
            <div class="col-md-6">
                <div class="card card-glass h-100 p-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="fs-1"> <?php echo htmlspecialchars($service['icon']); ?> </div>
                        <h4 class="section-title mb-0"> <?php echo htmlspecialchars($service['title']); ?> </h4>
                    </div>
                    <p class="text-muted mt-3"><?php echo htmlspecialchars($service['description']); ?></p>
                </div>
            </div>
        <?php endforeach; ?>
        <?php if (empty($services)) : ?>
            <p class="text-muted">Henüz hizmet eklenmedi. Yönetim panelinden yeni hizmet oluşturabilirsiniz.</p>
        <?php endif; ?>
    </div>
</div>
<?php include __DIR__ . '/partials/footer.php'; ?>
