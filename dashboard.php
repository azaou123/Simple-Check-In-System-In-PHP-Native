<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';
require_once 'includes/functions.php';

checkSessionTimeout();

if (!isLoggedIn()) {
    redirect('login.php');
}

$currentDate = getCurrentDate();
$currentTime = getCurrentTime();
$isMorning = ($currentTime < '12:00:00');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - <?= APP_NAME ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
    <?php include 'includes/navbar.php'; ?>
    
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <h2 class="card-title mb-4">Welcome, <?= $_SESSION['full_name'] ?></h2>
                        <p class="text-muted mb-4"><?= $currentDate ?> | <?= $currentTime ?></p>
                        
                        <?php if (hasRole('verifier')): ?>
                            <div class="d-grid gap-3 col-md-6 mx-auto">
                                <a href="verify.php" class="btn btn-primary btn-lg">
                                    <?= $isMorning ? 'Start Morning Check-in' : 'Start Evening Check-in' ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (hasRole('admin')): ?>
                            <div class="d-grid gap-3 col-md-6 mx-auto">
                                <a href="admin.php" class="btn btn-primary btn-lg">Admin Dashboard</a>
                                <a href="verify.php" class="btn btn-secondary btn-lg">Verify Attendance</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
