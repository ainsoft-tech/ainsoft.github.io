<?php
require __DIR__ . '/../config/database.php';
include __DIR__ . '/includes/header.php';

$statusOptions = ['Planlandı', 'Onay Bekliyor', 'Tamamlandı', 'İptal'];
$patients = $pdo->query('SELECT id, first_name, last_name FROM patients ORDER BY first_name')->fetchAll();
$editAppointment = null;

if (isset($_GET['edit'])) {
    $editId = (int) $_GET['edit'];
    $statement = $pdo->prepare('SELECT * FROM appointments WHERE id = :id');
    $statement->execute(['id' => $editId]);
    $editAppointment = $statement->fetch();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        $statement = $pdo->prepare('INSERT INTO appointments (patient_id, appointment_date, status, notes) VALUES (:patient_id, :appointment_date, :status, :notes)');
        $statement->execute([
            'patient_id' => (int) ($_POST['patient_id'] ?? 0),
            'appointment_date' => $_POST['appointment_date'] ?? '',
            'status' => trim($_POST['status'] ?? 'Planlandı'),
            'notes' => trim($_POST['notes'] ?? ''),
        ]);
    }

    if ($action === 'update') {
        $statement = $pdo->prepare('UPDATE appointments SET patient_id = :patient_id, appointment_date = :appointment_date, status = :status, notes = :notes WHERE id = :id');
        $statement->execute([
            'id' => (int) ($_POST['id'] ?? 0),
            'patient_id' => (int) ($_POST['patient_id'] ?? 0),
            'appointment_date' => $_POST['appointment_date'] ?? '',
            'status' => trim($_POST['status'] ?? 'Planlandı'),
            'notes' => trim($_POST['notes'] ?? ''),
        ]);
    }

    if ($action === 'delete') {
        $id = (int) ($_POST['id'] ?? 0);
        if ($id > 0) {
            $statement = $pdo->prepare('DELETE FROM appointments WHERE id = :id');
            $statement->execute(['id' => $id]);
        }
    }

    redirect('appointments.php');
}

$appointments = $pdo->query('SELECT appointments.*, patients.first_name, patients.last_name FROM appointments JOIN patients ON appointments.patient_id = patients.id ORDER BY appointment_date DESC')->fetchAll();
?>
<h1 class="section-title mb-4">Randevu Yönetimi</h1>
<div class="row g-4">
    <div class="col-lg-5">
        <div class="card card-glass p-4">
            <h5 class="section-title"><?php echo $editAppointment ? 'Randevu Güncelle' : 'Yeni Randevu Oluştur'; ?></h5>
            <form method="post" class="mt-3">
                <input type="hidden" name="action" value="<?php echo $editAppointment ? 'update' : 'add'; ?>">
                <?php if ($editAppointment) : ?>
                    <input type="hidden" name="id" value="<?php echo (int) $editAppointment['id']; ?>">
                <?php endif; ?>
                <div class="mb-3">
                    <label class="form-label">Danışan</label>
                    <select class="form-select" name="patient_id" required>
                        <option value="">Seçiniz</option>
                        <?php foreach ($patients as $patient) : ?>
                            <?php $selected = ($editAppointment['patient_id'] ?? 0) === (int) $patient['id']; ?>
                            <option value="<?php echo (int) $patient['id']; ?>" <?php echo $selected ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($patient['first_name'] . ' ' . $patient['last_name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Randevu Tarihi</label>
                    <input class="form-control" type="datetime-local" name="appointment_date" value="<?php echo $editAppointment ? htmlspecialchars(date('Y-m-d\TH:i', strtotime($editAppointment['appointment_date']))) : ''; ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Durum</label>
                    <select class="form-select" name="status">
                        <?php foreach ($statusOptions as $status) : ?>
                            <option value="<?php echo htmlspecialchars($status); ?>" <?php echo ($editAppointment['status'] ?? 'Planlandı') === $status ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($status); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Notlar</label>
                    <textarea class="form-control" name="notes" rows="3"><?php echo htmlspecialchars($editAppointment['notes'] ?? ''); ?></textarea>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-success" type="submit"><?php echo $editAppointment ? 'Güncelle' : 'Kaydet'; ?></button>
                    <?php if ($editAppointment) : ?>
                        <a class="btn btn-outline-secondary" href="appointments.php">Vazgeç</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="card card-glass p-4">
            <h5 class="section-title">Randevu Listesi</h5>
            <div class="table-responsive mt-3">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Danışan</th>
                            <th>Tarih</th>
                            <th>Durum</th>
                            <th>Not</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($appointments as $appointment) : ?>
                            <tr>
                                <td>
                                    <strong><?php echo htmlspecialchars($appointment['first_name'] . ' ' . $appointment['last_name']); ?></strong>
                                </td>
                                <td class="text-muted"><?php echo htmlspecialchars($appointment['appointment_date']); ?></td>
                                <td><span class="badge bg-success-subtle text-success"><?php echo htmlspecialchars($appointment['status']); ?></span></td>
                                <td class="text-muted"><?php echo htmlspecialchars($appointment['notes']); ?></td>
                                <td class="text-end">
                                    <a class="btn btn-outline-success btn-sm" href="appointments.php?edit=<?php echo (int) $appointment['id']; ?>">Düzenle</a>
                                    <form method="post" class="d-inline" onsubmit="return confirm('Randevu silinsin mi?');">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?php echo (int) $appointment['id']; ?>">
                                        <button class="btn btn-outline-danger btn-sm" type="submit">Sil</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($appointments)) : ?>
                            <tr>
                                <td colspan="5" class="text-muted">Henüz randevu oluşturulmadı.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
