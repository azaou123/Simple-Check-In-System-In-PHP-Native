<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

if (isLoggedIn()) {
    // Redirect to dashboard if already logged in
    redirect('dashboard.php');
} else {
    // Redirect to login page if not logged in
    redirect('login.php');
}
