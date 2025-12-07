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
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
      font-family: 'Inter', sans-serif;
    }

    body {
      margin: 0;
      padding: 0;
      background: linear-gradient(to right, #2c3e50, #3498db);
      color: #fff;
      min-height: 100vh;
    }

    .container {
      max-width: 1150px;
      margin: 40px auto;
      background: rgba(255, 255, 255, 0.05);
      padding: 2.5rem;
      border-radius: 16px;
      backdrop-filter: blur(12px);
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    }

    .logo-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 30px;
    }

    .logo-header img {
      width: 60px;
      height: 60px;
    }

    .logo-header h1 {
      font-size: 1.9rem;
      color: #f1c40f;
      margin-left: 10px;
    }

    h2 {
      margin-top: 40px;
      color: #1abc9c;
      font-weight: 600;
      border-bottom: 1px solid rgba(255, 255, 255, 0.2);
      padding-bottom: 6px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 1rem;
      background-color: rgba(255, 255, 255, 0.06);
      border-radius: 8px;
      overflow: hidden;
    }

    th, td {
      padding: 14px 16px;
      text-align: left;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    th {
      background-color: rgba(255, 255, 255, 0.12);
      color: #f39c12;
    }

    td {
      color: #ecf0f1;
    }

    tr:hover {
      background-color: rgba(255, 255, 255, 0.08);
    }

    .logout-btn {
      display: inline-block;
      background: #e74c3c;
      color: #fff;
      padding: 12px 20px;
      text-decoration: none;
      border-radius: 8px;
      font-weight: 600;
      transition: background 0.3s ease;
      margin-top: 30px;
      text-align: center;
    }

    .logout-btn:hover {
      background: #c0392b;
    }

    @media (max-width: 768px) {
      th, td {
        font-size: 14px;
        padding: 10px;
      }

      .container {
        margin: 20px;
        padding: 1.5rem;
      }

      .logo-header {
        flex-direction: column;
        align-items: center;
        text-align: center;
      }

      .logo-header img {
        margin-bottom: 10px;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="logo-header">
      <div style="display: flex; align-items: center;">
        <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="Admin Logo">
        <h1>Admin Dashboard</h1>
      </div>
      <a href="logout.php" class="logout-btn">Logout</a>
    </div>

    <h2>📘 Student Records</h2>
    <table>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Course</th>
        <th>Semester</th>
        <th>Department</th>
        <th>Email</th>
      </tr>
      <?php
      $result = $conn->query("SELECT * FROM students");
      while ($row = $result->fetch_assoc()) {
          echo "<tr>
                  <td>{$row['student_id']}</td>
                  <td>{$row['name']}</td>
                  <td>{$row['course']}</td>
                  <td>{$row['semester']}</td>
                  <td>{$row['department']}</td>
                  <td>{$row['email']}</td>
                </tr>";
      }
      ?>
    </table>

    <h2>🕒 Attendance Records</h2>
    <table>
      <tr>
        <th>ID</th>
        <th>Date</th>
        <th>Time</th>
      </tr>
      <?php
      $result = $conn->query("SELECT * FROM attendance");
      while ($row = $result->fetch_assoc()) {
          echo "<tr>
                  <td>{$row['student_id']}</td>
                  <td>{$row['date']}</td>
                  <td>{$row['time']}</td>
                </tr>";
      }
      ?>
    </table>
  </div>
</body>
</html>
