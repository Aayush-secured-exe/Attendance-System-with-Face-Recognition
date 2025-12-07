<?php
session_start();
$entered_otp = $_POST['otp'];

if ($entered_otp == $_SESSION['otp']) {
    echo "<script>window.location.href='reset_password.html';</script>";
} else {
    echo "<script>alert('Invalid OTP'); window.history.back();</script>";
}
?>
