<?php
require __DIR__ . '/../config/database.php';
include __DIR__ . '/includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $icon = trim($_POST['icon'] ?? '🥗');

        if ($title !== '' && $description !== '') {
            $statement = $pdo->prepare('INSERT INTO services (title, description, icon) VALUES (:title, :description, :icon)');
            $statement->execute([
                'title' => $title,
                'description' => $description,
                'icon' => $icon,
            ]);
        }
    }

    if ($action === 'delete') {
        $id = (int) ($_POST['id'] ?? 0);
        if ($id > 0) {
            $statement = $pdo->prepare('DELETE FROM services WHERE id = :id');
            $statement->execute(['id' => $id]);
        }
    }

    redirect('services.php');
}

$services = $pdo->query('SELECT id, title, description, icon FROM services ORDER BY id DESC')->fetchAll();
?>
<h1 class="section-title mb-4">Hizmet Yönetimi</h1>
<div class="row g-4">
    <div class="col-lg-5">
        <div class="card card-glass p-4">
            <h5 class="section-title">Yeni Hizmet Ekle</h5>
            <form method="post" class="mt-3">
                <input type="hidden" name="action" value="add">
                <div class="mb-3">
                    <label class="form-label">Hizmet Başlığı</label>
                    <input class="form-control" name="title" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Açıklama</label>
                    <textarea class="form-control" name="description" rows="4" required></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">İkon (Emoji)</label>
                    <input class="form-control" name="icon" placeholder="🥗">
                </div>
                <button class="btn btn-success" type="submit">Kaydet</button>
            </form>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="card card-glass p-4">
            <h5 class="section-title">Mevcut Hizmetler</h5>
            <div class="table-responsive mt-3">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Hizmet</th>
                            <th>Açıklama</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($services as $service) : ?>
                            <tr>
                                <td>
                                    <strong><?php echo htmlspecialchars($service['title']); ?></strong><br>
                                    <span class="text-muted"><?php echo htmlspecialchars($service['icon']); ?></span>
                                </td>
                                <td class="text-muted"><?php echo htmlspecialchars($service['description']); ?></td>
                                <td class="text-end">
                                    <form method="post" onsubmit="return confirm('Hizmet silinsin mi?');">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?php echo (int) $service['id']; ?>">
                                        <button class="btn btn-outline-danger btn-sm" type="submit">Sil</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($services)) : ?>
                            <tr>
                                <td colspan="3" class="text-muted">Henüz hizmet eklenmedi.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
