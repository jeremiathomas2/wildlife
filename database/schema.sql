-- Create database if it doesn't exist
CREATE DATABASE IF NOT EXISTS tourdb;
USE tourdb;

-- Tours table
CREATE TABLE IF NOT EXISTS tours (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  description TEXT,
  duration VARCHAR(100),
  price DECIMAL(10, 2),
  image VARCHAR(255),
  location VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Gallery table
CREATE TABLE IF NOT EXISTS gallery (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255),
  image VARCHAR(255),
  category VARCHAR(100),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Testimonials table
CREATE TABLE IF NOT EXISTS testimonials (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  text TEXT NOT NULL,
  rating INT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Team table
CREATE TABLE IF NOT EXISTS team (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  role VARCHAR(255),
  bio TEXT,
  image VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample data
INSERT INTO tours (name, description, duration, price, image, location) VALUES
('Kilimanjaro Safari', 'Experience the breathtaking wildlife of the Serengeti', '7 days', 2500.00, 'safari-kilimanjaro.jpg', 'Tanzania'),
('Zanzibar Beach Getaway', 'Relax on pristine white sand beaches', '5 days', 1500.00, 'tour-zanzibar.jpg', 'Zanzibar');
