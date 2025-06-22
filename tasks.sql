-- Create the database
CREATE DATABASE IF NOT EXISTS todo_dashboard;
USE todo_dashboard;

-- Drop old table if it exists
DROP TABLE IF EXISTS tasks;

-- Create updated tasks table with status column
CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    task VARCHAR(255) NOT NULL,
    status ENUM('Pending', 'In Progress', 'Completed') DEFAULT 'Pending',
    note TEXT,
    reminder DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample data
INSERT INTO tasks (task, status, note, reminder)
VALUES
('Finish Dashboard UI', 'Pending', 'Design side navigation and dark mode.', '2025-06-20 10:00:00'),
('Fix Edit Feature', 'Completed', 'Enable editing of reminder and note.', '2025-06-18 09:30:00'),
('Deploy to Server', 'Pending', 'Upload project to hosting platform.', '2025-06-22 15:45:00');
