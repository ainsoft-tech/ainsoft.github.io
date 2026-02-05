<?php
require __DIR__ . '/../../config/config.php';
require __DIR__ . '/../../config/helpers.php';
session_start();

if (!is_admin_logged_in() && basename($_SERVER['PHP_SELF']) !== 'login.php') {
    redirect('login.php');
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel | <?php echo htmlspecialchars($config['site']['name']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/assets/css/style.css">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-success">
    <div class="container">
        <a class="navbar-brand" href="dashboard.php">Admin Panel</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="adminNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="dashboard.php">Genel Bakış</a></li>
                <li class="nav-item"><a class="nav-link" href="services.php">Hizmetler</a></li>
                <li class="nav-item"><a class="nav-link" href="patients.php">Danışanlar</a></li>
                <li class="nav-item"><a class="nav-link" href="appointments.php">Randevular</a></li>
                <li class="nav-item"><a class="nav-link" href="messages.php">Mesajlar</a></li>
            </ul>
            <div class="d-flex gap-2">
                <a class="btn btn-outline-light" href="../public/index.php">Siteyi Görüntüle</a>
                <?php if (is_admin_logged_in()) : ?>
                    <a class="btn btn-light" href="logout.php">Çıkış</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>
<main class="container py-5">
