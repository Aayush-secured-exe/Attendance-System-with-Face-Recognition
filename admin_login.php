<?php
session_start();
include 'db_connect.php'; // Database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Query to check credentials
    $stmt = $conn->prepare("SELECT username, password FROM admin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if ($password === $row['password']) {  // Direct string comparison (no hashing)
            $_SESSION['admin'] = $username;
            header("Location: admin_dashboard.php"); // Redirect to dashboard
            exit();
        } else {
            echo "<script>alert('Incorrect password!'); window.location.href='admin_login.html';</script>";
        }
    } else {
        echo "<script>alert('Admin not found!'); window.location.href='admin_login.html';</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: admin_login.html");
    exit();
}
?>
