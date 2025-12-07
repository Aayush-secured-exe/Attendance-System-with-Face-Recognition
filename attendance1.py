import cv2
import face_recognition
import os
import sys
import numpy as np
import mysql.connector
from datetime import datetime

# === Load student images from 'uploads/' ===
path = 'uploads'
images = []
student_ids = []

for filename in os.listdir(path):
    if filename.endswith('.jpg') or filename.endswith('.png'):
        img = cv2.imread(os.path.join(path, filename))
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
encodeListKnown = findEncodings(images)
print("Encoding complete.")

# === Start webcam for recognition ===
cap = cv2.VideoCapture(0)
match_found = False
matched_id = None

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

    if match_found or cv2.waitKey(1) & 0xFF == ord('q'):
        break

cap.release()
cv2.destroyAllWindows()

# === If match found, update MySQL ===
if match_found:
    print(f"Match found: Student ID {matched_id}")

    # Connect to MySQL
    conn = mysql.connector.connect(
        host="localhost",
        user="root",
        password="",  # or your XAMPP MySQL password
        database="attendance_system"
    )
    cursor = conn.cursor()

    # Record attendance
    now = datetime.now()
    date = now.date()
    time = now.time()

    cursor.execute("INSERT INTO attendance (student_id, date, time) VALUES (%s, %s, %s)", (matched_id, date, time))
    conn.commit()

    # Redirect to student.html (you can open it in browser if needed)
    os.system("start chrome http://localhost/atten_sys/student.html")

else:
    print("No face matched.")
    # Redirect to not_found.html
    os.system("start chrome http://localhost/atten_sys/not_found.html")

sys.exit()
