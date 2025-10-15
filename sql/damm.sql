CREATE DATABASE IF NOT EXISTS mydatabase;
USE mydatabase;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    is_parent BOOLEAN,
    number_of_kids INT,
    kid1_gender VARCHAR(255),
    kid1_name VARCHAR(255),
    kid1_age INT,
    // Add columns for other kids if needed
);
