<?php
$config = require __DIR__ . '/../../config/config.php';
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($config['site']['name']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <span>Sağlıklı</span> Yaşam
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="index.php">Anasayfa</a></li>
                <li class="nav-item"><a class="nav-link" href="services.php">Hizmetler</a></li>
                <li class="nav-item"><a class="nav-link" href="about.php">Hakkımızda</a></li>
                <li class="nav-item"><a class="nav-link" href="contact.php">İletişim</a></li>
            </ul>
            <a class="btn btn-success ms-lg-3" href="../admin/login.php">Danışman Girişi</a>
        </div>
    </div>
</nav>
<main class="py-5">
