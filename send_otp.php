<?php
session_start();
require 'vendor/autoload.php'; // PHPMailer autoload

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$conn = new mysqli("localhost", "root", "", "attendance_system");

$email = $_POST["email"];
$otp = rand(100000, 999999);

// Check if email exists
$check = $conn->query("SELECT * FROM admin WHERE email='$email'");
if ($check->num_rows == 0) {
    echo "<script>alert('Email not found.'); window.history.back();</script>";
    exit();
}

$_SESSION['reset_email'] = $email;
$_SESSION['otp'] = $otp;

// Send OTP
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // your SMTP host
    $mail->SMTPAuth = true;
    $mail->Username = 'attensys.sender@gmail.com'; // your email
    $mail->Password = 'valz dkbi ibnk amhq';        // your email password or app password
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('attensys.sender@gmail.com', 'Attendance System');
    $mail->addAddress($email);

    $mail->Subject = 'OTP for Password Reset';
    $mail->Body    = "Your OTP is: $otp";

    $mail->send();
    echo "<script>alert('OTP sent to email.'); window.location.href='verify_otp.html';</script>";
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
