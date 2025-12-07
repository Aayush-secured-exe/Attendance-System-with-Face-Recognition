import cv2
import face_recognition
import os
import sys
import numpy as np
import mysql.connector
from datetime import datetime
import pyttsx3
import time

# === Voice Assistant Setup ===
engine = pyttsx3.init()

def speak(text):
    engine.say(text)
    engine.runAndWait()

# === Load student images from 'uploads/' ===
path = 'uploads'
images = []
student_ids = []

for filename in os.listdir(path):
    if filename.endswith('.jpg') or filename.endswith('.png'):
        img = cv2.imread(os.path.join(path, filename)) #uploads/image.jpg
        images.append(img)
        student_ids.append(os.path.splitext(filename)[0])  # e.g., 1001.jpg -> 1001

# === Encode known faces ===
def findEncodings(images):
    encodeList = []
    for img in images:
        img_rgb = cv2.cvtColor(img, cv2.COLOR_BGR2RGB)
        encodes = face_recognition.face_encodings(img_rgb)
        if encodes:
            encodeList.append(encodes[0])
    return encodeList

print("Encoding faces...")
speak("Encoding student faces, please wait.")
encodeListKnown = findEncodings(images)
print("Encoding complete.")
speak("Encoding complete. Starting face recognition please look in the Camera.")

# === Start webcam for recognition (LIMIT TO 7 SECONDS) ===
cap = cv2.VideoCapture(0)
match_found = False
matched_id = None
start_time = time.time()

while True:
    success, frame = cap.read()
    img_small = cv2.resize(frame, (0, 0), fx=0.25, fy=0.25)
    img_rgb = cv2.cvtColor(img_small, cv2.COLOR_BGR2RGB)

    faces_cur_frame = face_recognition.face_locations(img_rgb)
    encodes_cur_frame = face_recognition.face_encodings(img_rgb, faces_cur_frame)

    for encodeFace, faceLoc in zip(encodes_cur_frame, faces_cur_frame):
        matches = face_recognition.compare_faces(encodeListKnown, encodeFace)
        faceDis = face_recognition.face_distance(encodeListKnown, encodeFace)

        if len(faceDis) > 0:
            matchIndex = np.argmin(faceDis)

            if matches[matchIndex]:
                matched_id = student_ids[matchIndex]
                match_found = True
                break

    # Check for timeout (7 seconds) or match found
    if match_found or (time.time() - start_time > 5):
        break

cap.release()
cv2.destroyAllWindows()

# === If match found, update MySQL ===
if match_found:
    print(f"Match found: Student ID {matched_id}")
    speak(f"Attendance recorded for student ID {matched_id}")

    # Connect to MySQL
    conn = mysql.connector.connect(
        host="localhost",
        user="root",
        password="",  # Set your MySQL password if any
        database="attendance_system"
    )
    cursor = conn.cursor()

    # Record attendance
    now = datetime.now()
    date = now.date()
    time = now.time()

    cursor.execute("INSERT INTO attendance (student_id, date, time) VALUES (%s, %s, %s)", (matched_id, date, time))
    conn.commit()
    conn.close()

    # Redirect to student.html
    os.system("start chrome http://localhost/atten_sys/student.html")

else:
    print("No face recognized.")
    speak("Face not recognized. Please try again.")
    # Redirect to not_found.html
    os.system("start chrome http://localhost/atten_sys/not_found.html")

# === Farewell Message ===
print("Have a nice day!")
speak("Have a nice day!")

sys.exit()
