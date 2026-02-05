<?php
require __DIR__ . '/../config/database.php';
include __DIR__ . '/includes/header.php';

$editPatient = null;
$statusOptions = ['Aktif', 'Beklemede', 'Tamamlandı', 'Pasif'];

if (isset($_GET['edit'])) {
    $editId = (int) $_GET['edit'];
    $statement = $pdo->prepare('SELECT * FROM patients WHERE id = :id');
    $statement->execute(['id' => $editId]);
    $editPatient = $statement->fetch();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        $statement = $pdo->prepare('INSERT INTO patients (first_name, last_name, email, phone, status, notes) VALUES (:first_name, :last_name, :email, :phone, :status, :notes)');
        $statement->execute([
            'first_name' => trim($_POST['first_name'] ?? ''),
            'last_name' => trim($_POST['last_name'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'phone' => trim($_POST['phone'] ?? ''),
            'status' => trim($_POST['status'] ?? 'Aktif'),
            'notes' => trim($_POST['notes'] ?? ''),
        ]);
    }

    if ($action === 'update') {
        $statement = $pdo->prepare('UPDATE patients SET first_name = :first_name, last_name = :last_name, email = :email, phone = :phone, status = :status, notes = :notes WHERE id = :id');
        $statement->execute([
            'id' => (int) ($_POST['id'] ?? 0),
            'first_name' => trim($_POST['first_name'] ?? ''),
            'last_name' => trim($_POST['last_name'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'phone' => trim($_POST['phone'] ?? ''),
            'status' => trim($_POST['status'] ?? 'Aktif'),
            'notes' => trim($_POST['notes'] ?? ''),
        ]);
    }

    if ($action === 'delete') {
        $id = (int) ($_POST['id'] ?? 0);
        if ($id > 0) {
            $statement = $pdo->prepare('DELETE FROM patients WHERE id = :id');
            $statement->execute(['id' => $id]);
        }
    }

    redirect('patients.php');
}

$patients = $pdo->query('SELECT * FROM patients ORDER BY created_at DESC')->fetchAll();
?>
<h1 class="section-title mb-4">Danışan Yönetimi</h1>
<div class="row g-4">
    <div class="col-lg-5">
        <div class="card card-glass p-4">
            <h5 class="section-title"><?php echo $editPatient ? 'Danışanı Güncelle' : 'Yeni Danışan Ekle'; ?></h5>
            <form method="post" class="mt-3">
                <input type="hidden" name="action" value="<?php echo $editPatient ? 'update' : 'add'; ?>">
                <?php if ($editPatient) : ?>
                    <input type="hidden" name="id" value="<?php echo (int) $editPatient['id']; ?>">
                <?php endif; ?>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Ad</label>
                        <input class="form-control" name="first_name" value="<?php echo htmlspecialchars($editPatient['first_name'] ?? ''); ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Soyad</label>
                        <input class="form-control" name="last_name" value="<?php echo htmlspecialchars($editPatient['last_name'] ?? ''); ?>" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">E-posta</label>
                    <input class="form-control" type="email" name="email" value="<?php echo htmlspecialchars($editPatient['email'] ?? ''); ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Telefon</label>
                    <input class="form-control" name="phone" value="<?php echo htmlspecialchars($editPatient['phone'] ?? ''); ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Durum</label>
                    <select class="form-select" name="status">
                        <?php foreach ($statusOptions as $status) : ?>
                            <option value="<?php echo htmlspecialchars($status); ?>" <?php echo ($editPatient['status'] ?? 'Aktif') === $status ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($status); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Notlar</label>
                    <textarea class="form-control" name="notes" rows="3"><?php echo htmlspecialchars($editPatient['notes'] ?? ''); ?></textarea>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-success" type="submit"><?php echo $editPatient ? 'Güncelle' : 'Kaydet'; ?></button>
                    <?php if ($editPatient) : ?>
                        <a class="btn btn-outline-secondary" href="patients.php">Vazgeç</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="card card-glass p-4">
            <h5 class="section-title">Danışan Listesi</h5>
            <div class="table-responsive mt-3">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Danışan</th>
                            <th>İletişim</th>
                            <th>Durum</th>
                            <th>Tarih</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($patients as $patient) : ?>
                            <tr>
                                <td>
                                    <strong><?php echo htmlspecialchars($patient['first_name'] . ' ' . $patient['last_name']); ?></strong>
                                </td>
                                <td class="text-muted">
                                    <?php echo htmlspecialchars($patient['email']); ?><br>
                                    <?php echo htmlspecialchars($patient['phone']); ?>
                                </td>
                                <td><span class="badge bg-success-subtle text-success"><?php echo htmlspecialchars($patient['status']); ?></span></td>
                                <td class="text-muted"><?php echo htmlspecialchars($patient['created_at']); ?></td>
                                <td class="text-end">
                                    <a class="btn btn-outline-success btn-sm" href="patients.php?edit=<?php echo (int) $patient['id']; ?>">Düzenle</a>
                                    <form method="post" class="d-inline" onsubmit="return confirm('Danışan silinsin mi?');">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?php echo (int) $patient['id']; ?>">
                                        <button class="btn btn-outline-danger btn-sm" type="submit">Sil</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($patients)) : ?>
                            <tr>
                                <td colspan="5" class="text-muted">Henüz danışan eklenmedi.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
