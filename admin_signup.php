<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "attendance_system";

$conn = new mysqli($host, $user, $pass, $db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Check if username already exists
    $checkQuery = "SELECT * FROM admin WHERE username='$username'";
    $result = $conn->query($checkQuery);

    if ($result->num_rows > 0) {
        echo "<script>alert('Username already exists. Please choose another one.'); window.history.back();</script>";
    } elseif ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match.'); window.history.back();</script>";
    } else {
        // $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $insertQuery = "INSERT INTO admin (first_name, last_name, username, email, password) 
                        VALUES ('$fname', '$lname', '$username', '$email', '$password')";

        if ($conn->query($insertQuery) === TRUE) {
            echo "<script>alert('Sign Up Successful! Please login.'); window.location.href='admin_login.html';</script>";
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

$conn->close();
?>
