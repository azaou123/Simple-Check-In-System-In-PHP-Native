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
$sessionType = $isMorning ? 'morning' : 'evening';
$success = $error = '';

// Handle form submission
if (isset($_POST['verify'])) {
    $studentId = sanitizeInput($_POST['student_id']);
    
    try {
        $db = getDB();
        
        // Check if student exists
        $stmt = $db->prepare("SELECT id FROM students WHERE student_id = ?");
        $stmt->execute([$studentId]);
        $student = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$student) {
            $error = "Student ID not found in our records.";
        } else {
            // Check if attendance record exists for today
            $stmt = $db->prepare("SELECT id FROM attendance WHERE student_id = ? AND date = ?");
            $stmt->execute([$studentId, $currentDate]);
            $attendance = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($attendance) {
                // Update existing record
                if ($isMorning && empty($attendance['morning_checkin'])) {
                    $stmt = $db->prepare("UPDATE attendance SET morning_checkin = ?, verified_by = ? WHERE id = ?");
                    $stmt->execute([$currentTime, $_SESSION['user_id'], $attendance['id']]);
                    $success = "Morning check-in recorded successfully for student $studentId";
                } elseif (!$isMorning && empty($attendance['evening_checkin'])) {
                    $stmt = $db->prepare("UPDATE attendance SET evening_checkin = ?, verified_by = ? WHERE id = ?");
                    $stmt->execute([$currentTime, $_SESSION['user_id'], $attendance['id']]);
                    $success = "Evening check-in recorded successfully for student $studentId";
                } else {
                    $error = ucfirst($sessionType) . " check-in already recorded for this student today.";
                }
            } else {
                // Create new record
                if ($isMorning) {
                    $stmt = $db->prepare("INSERT INTO attendance (student_id, date, morning_checkin, verified_by) VALUES (?, ?, ?, ?)");
                    $stmt->execute([$studentId, $currentDate, $currentTime, $_SESSION['user_id']]);
                    $success = "Morning check-in recorded successfully for student $studentId";
                } else {
                    $stmt = $db->prepare("INSERT INTO attendance (student_id, date, evening_checkin, verified_by) VALUES (?, ?, ?, ?)");
                    $stmt->execute([$studentId, $currentDate, $currentTime, $_SESSION['user_id']]);
                    $success = "Evening check-in recorded successfully for student $studentId";
                }
            }
        }
    } catch (PDOException $e) {
        error_log("Verification error: " . $e->getMessage());
        $error = "An error occurred. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Attendance - <?= APP_NAME ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
    <?php include 'includes/navbar.php'; ?>
    
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4"><?= ucfirst($sessionType) ?> Check-in</h2>
                        <p class="text-muted text-center"><?= $currentDate ?> | <?= $currentTime ?></p>
                        
                        <?php if ($success): ?>
                            <div class="alert alert-success"><?= $success ?></div>
                        <?php endif; ?>
                        
                        <?php if ($error): ?>
                            <div class="alert alert-danger"><?= $error ?></div>
                        <?php endif; ?>
                        
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label for="student_id" class="form-label">Student ID</label>
                                <input type="text" class="form-control" id="student_id" name="student_id" required autofocus>
                            </div>
                            <div class="d-grid">
                                <button type="submit" name="verify" class="btn btn-primary">
                                    Record <?= ucfirst($sessionType) ?> Check-in
                                </button>
                            </div>
                        </form>
                        
                        <div class="mt-4 text-center">
                            <a href="dashboard.php" class="btn btn-outline-secondary">Back to Dashboard</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Focus on student ID field on page load
        document.getElementById('student_id').focus();
    </script>
</body>
</html>
