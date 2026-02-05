<?php
require __DIR__ . '/../config/database.php';
require __DIR__ . '/../config/helpers.php';
require __DIR__ . '/../config/config.php';

session_start();

if (is_admin_logged_in()) {
    redirect('dashboard.php');
}

$errorMessage = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $statement = $pdo->prepare('SELECT id, name, password_hash FROM admin_users WHERE email = :email LIMIT 1');
    $statement->execute(['email' => $email]);
    $user = $statement->fetch();

    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['admin_id'] = $user['id'];
        $_SESSION['admin_name'] = $user['name'];
        redirect('dashboard.php');
    }

    $errorMessage = 'E-posta veya şifre hatalı.';
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Girişi | <?php echo htmlspecialchars($config['site']['name']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/assets/css/style.css">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="card card-glass p-4">
                <h2 class="section-title mb-3">Admin Girişi</h2>
                <p class="text-muted">Yetkili hesap ile giriş yapınız.</p>
                <?php if ($errorMessage) : ?>
                    <div class="alert alert-danger"> <?php echo htmlspecialchars($errorMessage); ?> </div>
                <?php endif; ?>
                <form method="post">
                    <div class="mb-3">
                        <label class="form-label">E-posta</label>
                        <input class="form-control" type="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Şifre</label>
                        <input class="form-control" type="password" name="password" required>
                    </div>
                    <button class="btn btn-success w-100" type="submit">Giriş Yap</button>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
