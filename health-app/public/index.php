<?php
require __DIR__ . '/../config/database.php';

$services = $pdo->query('SELECT id, title, description, icon FROM services ORDER BY id DESC LIMIT 6')->fetchAll();

include __DIR__ . '/partials/header.php';
?>
<div class="container">
    <div class="hero mb-5">
        <div class="card-glass p-4 p-lg-5">
            <h1 class="display-5 fw-bold text-success">Sağlıklı beslenme, dengeli yaşam.</h1>
            <p class="lead text-muted">Kişiye özel beslenme programları, yaşam koçluğu ve bütüncül sağlık çözümleriyle hedeflerinize ulaşın.</p>
            <div class="d-flex gap-3">
                <a href="contact.php" class="btn btn-success btn-lg">Ücretsiz Ön Görüşme</a>
                <a href="services.php" class="btn btn-outline-success btn-lg">Hizmetleri İncele</a>
            </div>
        </div>
    </div>

    <section class="mb-5">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card card-glass h-100 p-4">
                    <span class="badge badge-soft mb-3">%100 Kişiselleştirilmiş</span>
                    <h3 class="section-title">Beslenme Danışmanlığı</h3>
                    <p class="text-muted">Metabolizmanıza, yaşam stilinize ve hedeflerinize göre hazırlanan planlarla sürdürülebilir sonuçlar.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-glass h-100 p-4">
                    <span class="badge badge-soft mb-3">Bütüncül Yaklaşım</span>
                    <h3 class="section-title">Sağlıklı Yaşam Koçluğu</h3>
                    <p class="text-muted">Uyku, hareket ve stres yönetimini kapsayan yol haritası ile yaşam kalitenizi artırın.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-glass h-100 p-4">
                    <span class="badge badge-soft mb-3">Online &amp; Yüz Yüze</span>
                    <h3 class="section-title">Kurumsal Programlar</h3>
                    <p class="text-muted">Şirketinizin çalışan sağlığını destekleyen seminerler ve atölyeler tasarlıyoruz.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="section-title">Öne Çıkan Hizmetler</h2>
            <a class="btn btn-outline-success" href="services.php">Tüm Hizmetler</a>
        </div>
        <div class="row g-4">
            <?php foreach ($services as $service) : ?>
                <div class="col-md-4">
                    <div class="card card-glass h-100 p-4">
                        <div class="d-flex align-items-center gap-3">
                            <div class="fs-1"> <?php echo htmlspecialchars($service['icon']); ?> </div>
                            <h5 class="section-title mb-0"> <?php echo htmlspecialchars($service['title']); ?> </h5>
                        </div>
                        <p class="text-muted mt-3"><?php echo htmlspecialchars($service['description']); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php if (empty($services)) : ?>
                <p class="text-muted">Henüz hizmet eklenmedi. Yönetim panelinden hizmet ekleyebilirsiniz.</p>
            <?php endif; ?>
        </div>
    </section>

    <section class="mb-5">
        <div class="row align-items-center g-4">
            <div class="col-lg-6">
                <img class="img-fluid rounded-4 shadow" src="https://images.unsplash.com/photo-1524594152303-9fd13543fe6e?auto=format&fit=crop&w=900&q=80" alt="Sağlıklı yaşam">
            </div>
            <div class="col-lg-6">
                <h2 class="section-title">Sizi dinliyor, birlikte planlıyoruz.</h2>
                <p class="text-muted">İlk görüşmede yaşam tarzınızı analiz ediyor, hedeflerinize uygun bir yol haritası oluşturuyoruz. Süreç boyunca ölçülebilir verilerle motivasyonunuzu artırıyoruz.</p>
                <ul class="list-unstyled">
                    <li class="mb-2">✅ Haftalık takip ve değerlendirme</li>
                    <li class="mb-2">✅ Sağlıklı tarif ve alışveriş listeleri</li>
                    <li class="mb-2">✅ Mobil uyumlu takip dokümanları</li>
                </ul>
            </div>
        </div>
    </section>
</div>
<?php include __DIR__ . '/partials/footer.php'; ?>
