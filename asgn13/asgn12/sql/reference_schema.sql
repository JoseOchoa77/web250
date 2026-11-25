-- Reference only: compare with your existing Assignment 10 birds database.
-- The sample solution expects these columns. DO NOT delete or recreate
-- tables that already contain course data.
-- Select your existing wnc_birds database in phpMyAdmin first.
Use wnc_birds;
-- Create MEMBERS if it does not already exist from Assignment 11.
CREATE TABLE IF NOT EXISTS members (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(80) NOT NULL,
    last_name VARCHAR(80) NOT NULL,
    email VARCHAR(190) NOT NULL UNIQUE,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('member', 'admin') NOT NULL DEFAULT 'member',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Existing WNC birds schema may differ; this sample is for a NEW empty
-- test database and is not necessary when birds already exists.
CREATE TABLE IF NOT EXISTS birds (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    common_name VARCHAR(150) NOT NULL,
    scientific_name VARCHAR(150) NOT NULL,
    family_name VARCHAR(150) NOT NULL DEFAULT '',
    primary_habitat VARCHAR(255) NOT NULL DEFAULT '',
    seasonal_status VARCHAR(100) NOT NULL DEFAULT '',
    description TEXT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Assignment 12 uses public registration followed by a targeted admin promotion.
-- To test admin personalization, register a separate test account, then,
-- after checking the username in phpMyAdmin, run a targeted role change:
-- UPDATE members SET role='admin' WHERE username='admin_demo';
-- Public signup never allows choosing admin.
