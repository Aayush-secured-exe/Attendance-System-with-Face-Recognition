<?php
session_start();
$conn = new mysqli("localhost", "root", "", "attendance_system");

$new_pass = $_POST["new_password"];
$confirm = $_POST["confirm_password"];
$email = $_SESSION["reset_email"];

if ($new_pass != $confirm) {
    echo "<script>alert('Passwords do not match'); window.history.back();</script>";
    exit();
}

// $hashed = password_hash($new_pass, PASSWORD_DEFAULT);
$update = "UPDATE admin SET password='$new_pass' WHERE email='$email'";
if ($conn->query($update)) {
    echo "<script>alert('Password updated successfully. Please login.'); window.location.href='admin_login.html';</script>";
} else {
    echo "Error: " . $conn->error;
}
?>
