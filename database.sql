CREATE DATABASE quran_platform CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE quran_platform;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'teacher', 'student', 'parent') NOT NULL,
    full_name VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    progress TEXT,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sender_id INT,
    receiver_id INT,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sender_id) REFERENCES users(id),
    FOREIGN KEY (receiver_id) REFERENCES users(id)
);

CREATE TABLE attendance (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    date DATE,
    status ENUM('present', 'absent') NOT NULL,
    FOREIGN KEY (student_id) REFERENCES students(id)
);

CREATE TABLE classes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    teacher_id INT,
    class_time DATETIME,
    description TEXT,
    FOREIGN KEY (teacher_id) REFERENCES users(id)
);

CREATE TABLE parent_students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    parent_id INT NOT NULL,
    student_id INT NOT NULL,
    FOREIGN KEY (parent_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    UNIQUE (parent_id, student_id)
);

CREATE TABLE recitations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    surah_name VARCHAR(100) NOT NULL,
    reciter_name VARCHAR(100) NOT NULL,
    audio_path VARCHAR(255) NOT NULL,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    `key` VARCHAR(100) UNIQUE NOT NULL,
    `value` TEXT
);

CREATE TABLE favorites (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    recitation_id INT NOT NULL,
    FOREIGN KEY (student_id) REFERENCES students(id),
    FOREIGN KEY (recitation_id) REFERENCES recitations(id),
    UNIQUE (student_id, recitation_id)
);

CREATE TABLE daily_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    log_date DATE NOT NULL,
    type ENUM('memorize', 'review') NOT NULL,
    UNIQUE(student_id, log_date, type),
    FOREIGN KEY (student_id) REFERENCES students(id)
);

CREATE TABLE achievements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(50) UNIQUE,     -- ex: 'streak_5', 'memorized_3_surahs'
    title VARCHAR(100),
    description TEXT
);

CREATE TABLE student_achievements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    achievement_id INT,
    awarded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE(student_id, achievement_id),
    FOREIGN KEY (student_id) REFERENCES students(id),
    FOREIGN KEY (achievement_id) REFERENCES achievements(id)
);

ALTER TABLE users ADD COLUMN is_approved BOOLEAN DEFAULT 0;
