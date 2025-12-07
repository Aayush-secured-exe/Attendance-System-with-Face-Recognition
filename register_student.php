<?php
include 'db_connect.php'; // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = trim($_POST['student_id']);
    $name = trim($_POST['name']);
    $course = trim($_POST['course']);
    $semester = intval($_POST['semester']);
    $department = trim($_POST['department']);
    $email = trim($_POST['email']);

    // Image upload handling
    $target_dir = "uploads/";  // Folder to store images
    $image_file = $target_dir . basename($_FILES["face_image"]["name"]);
    $imageFileType = strtolower(pathinfo($image_file, PATHINFO_EXTENSION));

    // Validate image format
    if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png") {
        echo "<script>alert('Only JPG, JPEG, and PNG files are allowed!'); window.location.href='new_student.html';</script>";
        exit();
    }

    // Move uploaded file to target folder
    if (move_uploaded_file($_FILES["face_image"]["tmp_name"], $image_file)) {
        // Save student details in database
        $stmt = $conn->prepare("INSERT INTO students (student_id, name, course, semester, department, email, face_image) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssisss", $student_id, $name, $course, $semester, $department, $email, $image_file);

        if ($stmt->execute()) {
            echo "<script>alert('Registration successful!'); window.location.href='new_student.html';</script>";
        } else {
            echo "<script>alert('Error: Could not register student.'); window.location.href='new_student.html';</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Error uploading file!'); window.location.href='new_student.html';</script>";
    }
    
    $conn->close();
} else {
    header("Location: new_student.html");
    exit();
}
?>
