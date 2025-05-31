<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'event_attendance');

// Application settings
define('APP_NAME', 'Event Attendance System');
define('APP_VERSION', '1.0.0');
define('BASE_URL', 'http://localhost/event_attendance');

// Security settings
define('MAX_LOGIN_ATTEMPTS', 5);
define('SESSION_TIMEOUT', 1800); // 30 minutes

// Start session
session_start();

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../error.log');

// Timezone
date_default_timezone_set('Africa/Casablanca');
