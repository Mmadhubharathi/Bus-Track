CREATE DATABASE bus_pass_management;

USE bus_pass_management;

-- Table for storing user details
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    phone VARCHAR(15),
    password VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table for storing bus pass details
CREATE TABLE passes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    pass_number VARCHAR(100) UNIQUE,
    pass_type ENUM('monthly', 'quarterly', 'annual') NOT NULL,
    start_date DATE,
    end_date DATE,
    status ENUM('active', 'expired', 'suspended') DEFAULT 'active',
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Table for tracking pass usage
CREATE TABLE usage (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pass_id INT,
    usage_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (pass_id) REFERENCES passes(id)
);
