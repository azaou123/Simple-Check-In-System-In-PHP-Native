<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';
require_once 'includes/functions.php';

checkSessionTimeout();

if (!isLoggedIn() || !hasRole('admin')) {
    redirect('login.php');
}

$currentDate = getCurrentDate();
$success = $error = '';

// Handle export request
if (isset($_GET['export'])) {
    $date = isset($_GET['date']) ? sanitizeInput($_GET['date']) : $currentDate;
    
    try {
        $db = getDB();
        $stmt = $db->prepare("
            SELECT a.student_id, s.full_name, a.morning_checkin, a.evening_checkin, u.full_name as verified_by
            FROM attendance a
            LEFT JOIN students s ON a.student_id = s.student_id
            LEFT JOIN users u ON a.verified_by = u.id
            WHERE a.date = ?
            ORDER BY a.student_id
        ");
        $stmt->execute([$date]);
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if ($records) {
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="attendance_' . $date . '.csv"');
            
            $output = fopen('php://output', 'w');
            fputcsv($output, ['Student ID', 'Full Name', 'Morning Check-in', 'Evening Check-in', 'Verified By']);
            
            foreach ($records as $record) {
                fputcsv($output, $record);
            }
            
            fclose($output);
            exit();
        } else {
            $error = "No attendance records found for $date";
        }
    } catch (PDOException $e) {
        error_log("Export error: " . $e->getMessage());
        $error = "Export failed. Please try again.";
    }
}

// Get attendance summary
try {
    $db = getDB();
    
    // Today's attendance
    $stmt = $db->prepare("
        SELECT 
            COUNT(DISTINCT student_id) as total_students,
            SUM(CASE WHEN morning_checkin IS NOT NULL THEN 1 ELSE 0 END) as morning_checkins,
            SUM(CASE WHEN evening_checkin IS NOT NULL THEN 1 ELSE 0 END) as evening_checkins
        FROM attendance
        WHERE date = ?
    ");
    $stmt->execute([$currentDate]);
    $todaySummary = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Recent check-ins
    $stmt = $db->prepare("
        SELECT a.student_id, s.full_name, 
               a.morning_checkin, a.evening_checkin, 
               u.full_name as verified_by
        FROM attendance a
        LEFT JOIN students s ON a.student_id = s.student_id
        LEFT JOIN users u ON a.verified_by = u.id
        WHERE a.date = ?
        ORDER BY a.id DESC
        LIMIT 10
    ");
    $stmt->execute([$currentDate]);
    $recentCheckins = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Admin dashboard error: " . $e->getMessage());
    $error = "Failed to load dashboard data. Please try again.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - <?= APP_NAME ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'includes/navbar.php'; ?>
    
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-md-3">
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Today's Summary</h5>
                        <div class="list-group">
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    <span>Date:</span>
                                    <strong><?= $currentDate ?></strong>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    <span>Total Students:</span>
                                    <strong><?= $todaySummary['total_students'] ?? 0 ?></strong>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    <span>Morning Check-ins:</span>
                                    <strong><?= $todaySummary['morning_checkins'] ?? 0 ?></strong>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    <span>Evening Check-ins:</span>
                                    <strong><?= $todaySummary['evening_checkins'] ?? 0 ?></strong>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-3">
                            <form method="GET" action="">
                                <div class="mb-3">
                                    <label for="date" class="form-label">Export Attendance</label>
                                    <input type="date" class="form-control" id="date" name="date" value="<?= $currentDate ?>">
                                </div>
                                <button type="submit" name="export" class="btn btn-success w-100">
                                    <i class="bi bi-download"></i> Export CSV
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-9">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Recent Check-ins</h5>
                        
                        <?php if ($error): ?>
                            <div class="alert alert-danger"><?= $error ?></div>
                        <?php endif; ?>
                        
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="checkinsTable">
                                <thead>
                                    <tr>
                                        <th>Student ID</th>
                                        <th>Full Name</th>
                                        <th>Morning</th>
                                        <th>Evening</th>
                                        <th>Verified By</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recentCheckins as $checkin): ?>
                                        <tr>
                                            <td><?= $checkin['student_id'] ?></td>
                                            <td><?= $checkin['full_name'] ?></td>
                                            <td><?= $checkin['morning_checkin'] ?: '-' ?></td>
                                            <td><?= $checkin['evening_checkin'] ?: '-' ?></td>
                                            <td><?= $checkin['verified_by'] ?: '-' ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#checkinsTable').DataTable({
                responsive: true,
                order: [[0, 'desc']]
            });
        });
    </script>
</body>
</html>
