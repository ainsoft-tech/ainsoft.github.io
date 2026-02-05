<?php
require __DIR__ . '/../config/database.php';
include __DIR__ . '/includes/header.php';

$messages = $pdo->query('SELECT id, name, email, phone, message, created_at FROM contact_messages ORDER BY created_at DESC')->fetchAll();
?>
<h1 class="section-title mb-4">İletişim Mesajları</h1>
<div class="card card-glass p-4">
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Gönderen</th>
                    <th>İletişim</th>
                    <th>Mesaj</th>
                    <th>Tarih</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($messages as $message) : ?>
                    <tr>
                        <td>
                            <strong><?php echo htmlspecialchars($message['name']); ?></strong>
                        </td>
                        <td class="text-muted">
                            <?php echo htmlspecialchars($message['email']); ?><br>
                            <?php echo htmlspecialchars($message['phone']); ?>
                        </td>
                        <td class="text-muted"> <?php echo htmlspecialchars($message['message']); ?> </td>
                        <td class="text-muted"><?php echo htmlspecialchars($message['created_at']); ?></td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($messages)) : ?>
                    <tr>
                        <td colspan="4" class="text-muted">Henüz mesaj yok.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
