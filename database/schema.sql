CREATE DATABASE IF NOT EXISTS student_portal CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE student_portal;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('student','admin') DEFAULT 'student',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(20) NOT NULL UNIQUE,
    title VARCHAR(150) NOT NULL,
    description TEXT,
    credits TINYINT NOT NULL DEFAULT 3,
    capacity INT NOT NULL DEFAULT 30,
    enrolled INT NOT NULL DEFAULT 0,
    semester VARCHAR(20) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE registrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    course_id INT NOT NULL,
    registered_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_registration (student_id, course_id),
    FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
);

INSERT INTO users (name, email, password_hash, role) VALUES
('Admin', 'admin@portal.dev', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

INSERT INTO courses (code, title, description, credits, capacity, semester) VALUES
('CS101', 'Intro to Computer Science', 'Fundamentals of programming and computational thinking.', 3, 40, '2025/1'),
('CS201', 'Data Structures', 'Arrays, linked lists, trees, graphs, and algorithms.', 3, 35, '2025/1'),
('MT101', 'Calculus I', 'Limits, derivatives, and integrals.', 4, 50, '2025/1'),
('CS301', 'Database Systems', 'Relational databases, SQL, and data modeling.', 3, 30, '2025/1'),
('EN101', 'Technical Writing', 'Writing for engineers and scientists.', 2, 45, '2025/1');
