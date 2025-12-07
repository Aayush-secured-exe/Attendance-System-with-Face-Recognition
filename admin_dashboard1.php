<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.html");
    exit();
}
include 'db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Welcome, Admin</h1>
        <h2>Student Records</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Course</th>
                <th>Session</th>
                <th>Department</th>
                <th>Registered At</th>
            </tr>
            <?php
            $result = $conn->query("SELECT * FROM students");
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['student_id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['course']}</td>
                        <td>{$row['session']}</td>
                        <td>{$row['department']}</td>
                        <td>{$row['registered_at']}</td>
                      </tr>";
            }
            ?>
        </table>

        <h2>Attendance Records</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Student Name</th>
                <th>Date</th>
                <th>Time</th>
            </tr>
            <?php
            $result = $conn->query("SELECT * FROM attendance");
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['attendance_id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['date']}</td>
                        <td>{$row['time']}</td>
                      </tr>";
            }
            ?>
        </table>

        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</body>
</html>
