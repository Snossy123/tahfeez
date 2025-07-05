-- جدول المستخدمين
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  email VARCHAR(100) UNIQUE,
  password VARCHAR(255),
  whatsapp_number VARCHAR(20),   // لازم يكون الرقم بالشكل الدولي (مثال: +201001234567)
  role ENUM('teacher', 'student'),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- جدول الطلاب
CREATE TABLE students (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  grade VARCHAR(50),
  teacher_id INT,
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (teacher_id) REFERENCES users(id)
);

-- جدول الدروس
CREATE TABLE lessons (
  id INT AUTO_INCREMENT PRIMARY KEY,
  teacher_id INT,
  date DATE,
  time TIME,
  duration INT,
  google_meet_link VARCHAR(255),
  notes TEXT,
  notified TINYINT DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (teacher_id) REFERENCES users(id)
);

CREATE TABLE lesson_student (
  id INT AUTO_INCREMENT PRIMARY KEY,
  lesson_id INT,
  student_id INT,
  attendance ENUM('present','absent') DEFAULT NULL,
  rating TINYINT UNSIGNED NULL,
  notes TEXT NULL,
  FOREIGN KEY (lesson_id) REFERENCES lessons(id) ON DELETE CASCADE,
  FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE
);

CREATE TABLE subscriptions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  student_id INT,
  start_date DATE,
  end_date DATE,
  total_lessons INT,
  used_lessons INT DEFAULT 0,
  FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE
);

