# Face Recognition Attendance System

A fully automated, real-time **Face Recognition Attendance System** built using Python and OpenCV, designed to replace manual and RFID-based attendance methods.  
The system captures faces through a webcam, identifies the student using stored facial embeddings, and records attendance directly into a MySQL database.  
A modern HTML/CSS/JS interface provides a seamless user experience for both students and administrators.

---

## 🚀 Overview

Traditional attendance systems are slow, error-prone, and vulnerable to proxy attendance.  
This project delivers a **secure, fast, and accurate AI-powered solution** that automates the entire workflow:

- **Face detection & recognition**
- **Real-time attendance logging**
- **Student registration with image capture**
- **Admin dashboard for data management**
- **OTP-based verification & password reset**
- **Automatic redirect UX after attendance**

The system works locally via XAMPP and is fully scalable for cloud deployment.

---

## 🧠 Core Features

### 🎥 Real-Time Face Recognition
- Uses **OpenCV**, Haar Cascade/DNN models, and LBPH for accurate recognition.
- Matches faces instantly against existing student embeddings.
- Initiates attendance marking only on successful recognition.

### 🧑‍🎓 Student Registration
- Input fields for student details (ID, semester, course, etc.).
- Captures facial data & stores embeddings for future recognition.
- Hosted on a dedicated registration page.

### 📝 Automated Attendance Marking
- Stores attendance in **MySQL** with date and time.
- Prevents duplicate entries for the same day.
- Displays student details and total attendance count after recognition.

### 🔐 Admin Panel
- Secure admin login.
- Manage students, attendance data, and system configurations.
- Supports OTP-based login recovery and password reset.

### 🌐 Modern Frontend
- Responsive UI built with **HTML, CSS, and JavaScript**.
- Webcam integration for browser-side scanning.
- Clean dark-themed interface.

### 🔁 Optimized UX Flow
- Successful attendance → **auto-redirect in 3 seconds**.
- Manual *Close* button for instant navigation.
- Not-found state includes a **Try Again** option.

---

## 🏗️ System Architecture

### ⚙️ Technologies Used
- **Python** (OpenCV, LBPH, DNN face detection)
- **HTML, CSS, JavaScript**
- **PHP** (backend logic for admin, OTP, session handling)
- **MySQL** (student data, attendance records)
- **XAMPP** (Apache + MySQL hosting)

### 📂 Project Structure (generalized)
```
/
├─ uploads/ # Stored student face images
├─ main.py # Primary face-recognition script (webcam + DB update)
├─ admin_login/ # Admin authentication pages
├─ new_student/ # Registration interface
├─ attendance/ # Attendance UI pages
├─ verify_otp/ # OTP verification logic
├─ reset_password/ # Password reset pages
├─ not_found.html # No-face-match screen
├─ student.html # Success screen + auto-redirect
├─ index.html # Landing page
├─ styles.css # UI styling
├─ db_connect.php # Database configuration
└─ assets/ # Images, logos, backgrounds
```

---

## 🗄️ Database Schema (MySQL)

### Students Table
student_id (primary)
name
semester
department
image_path
created_at (timestamp)

### Attendance Table
id (auto increment)
student_id
date
time

---

## ▶️ How to Run the System

### 1️⃣ Start XAMPP Services
- Enable **Apache** and **MySQL**.

### 2️⃣ Import Database
- Use phpMyAdmin to create required tables.

### 3️⃣ Place Project Inside htdocs/
- C:/xampp/htdocs/face-attendance-system/

### 4️⃣ Run the Face Recognition Script
- python main.py

### 5️⃣ Open Browser
- http://localhost/face-attendance-system/

You are now ready to:
- Register new students  
- Take real-time attendance  
- Access admin dashboard  

---

## 🛠️ Installation Requirements

### Python Packages
opencv-python
face_recognition
numpy
pyttsx3
mysql-connector-python

Install using:
pip install -r requirements.txt

### Softwares Required
- **XAMPP**
- **Python 3.x**
- **Webcam**

---

## 🔒 Security Considerations
- Facial data stored securely on the server.
- OTP-based account recovery for admins.
- Protection against proxy attendance.
- Local database communication via secure scripts.

---

## 📈 Scalability
This system can be extended to:
- Multiple departments / college-wide usage
- Cloud-based recognition APIs
- Mobile app integration
- QR + Face hybrid systems

---

## ⭐ Contributing
Contributions, improvements, and feature requests are welcome!

---

## 🙌 Acknowledgements
Built using OpenCV, LBPH, MySQL, and PHP technologies.
