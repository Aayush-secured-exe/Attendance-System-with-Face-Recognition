<?php
session_start();
$conn = new mysqli("localhost", "root", "", "attendance_system");

$newpass = $_POST['newpass'];
$confirmpass = $_POST['confirmpass'];
$email = $_SESSION['reset_email'];

if ($newpass !== $confirmpass) {
    echo "<script>alert('Passwords do not match'); window.history.back();</script>";
    exit();
}

$hashed = password_hash($newpass, PASSWORD_DEFAULT);
$conn->query("UPDATE admin SET password='$hashed' WHERE email='$email'");
echo "<script>alert('Password Updated Successfully'); window.location.href='admin_login.html';</script>";
?>
