-- De Guzman Resort database
-- Open this file in MySQL Workbench and execute the entire script.

CREATE DATABASE IF NOT EXISTS de_guzman_resort
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE de_guzman_resort;

-- Local application account used by Model/DB_Model.php.
-- This account can only connect locally and read or add project records.
CREATE USER IF NOT EXISTS 'resort_app'@'localhost'
    IDENTIFIED BY 'ResortLocal2026!';

ALTER USER 'resort_app'@'localhost'
    IDENTIFIED BY 'ResortLocal2026!';

GRANT SELECT, INSERT ON de_guzman_resort.* TO 'resort_app'@'localhost';

CREATE TABLE IF NOT EXISTS staff (
    employee_id VARCHAR(20) PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    position VARCHAR(100) NOT NULL,
    department VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(30) NOT NULL,
    status ENUM('On Duty', 'On Leave', 'Off Duty') NOT NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS customers (
    customer_id VARCHAR(20) PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(30) NOT NULL,
    last_stay VARCHAR(50) NOT NULL,
    guest_type VARCHAR(50) NOT NULL,
    status ENUM('Active', 'Inactive') NOT NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS services (
    service_id VARCHAR(20) PRIMARY KEY,
    service_name VARCHAR(100) NOT NULL,
    category VARCHAR(100) NOT NULL,
    duration VARCHAR(50) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    status ENUM('Available', 'Limited', 'Unavailable') NOT NULL
) ENGINE=InnoDB;

INSERT INTO staff (employee_id, name, position, department, email, phone, status) VALUES
    ('DGR-1001', 'Juan Miguel Reyes', 'Front Office Manager', 'Front Office', 'juan.reyes@dgr.com', '+63 917 234 8102', 'On Duty'),
    ('DGR-1002', 'Angela Cruz', 'Guest Relations Officer', 'Front Office', 'angela.cruz@dgr.com', '+63 918 651 8820', 'On Duty'),
    ('DGR-1003', 'Roberto Dela Pena', 'Head Chef', 'Food and Beverage', 'roberto.delapena@dgr.com', '+63 917 758 1143', 'On Duty'),
    ('DGR-1004', 'Liza Mercado', 'Housekeeping Supervisor', 'Housekeeping', 'liza.mercado@dgr.com', '+63 919 330 6217', 'On Leave'),
    ('DGR-1005', 'Carlo Villanueva', 'Pool Attendant', 'Recreation', 'carlo.villanueva@dgr.com', '+63 917 894 5006', 'Off Duty')
ON DUPLICATE KEY UPDATE name = VALUES(name), position = VALUES(position), department = VALUES(department), email = VALUES(email), phone = VALUES(phone), status = VALUES(status);

INSERT INTO customers (customer_id, name, email, phone, last_stay, guest_type, status) VALUES
    ('CUS-2001', 'Maria C. Santos', 'maria.santos@email.com', '+63 917 423 0921', 'July 22-24, 2026', 'VIP Guest', 'Active'),
    ('CUS-2002', 'Daniel Flores', 'daniel.flores@email.com', '+63 918 651 8820', 'June 10-12, 2026', 'Returning Guest', 'Active'),
    ('CUS-2003', 'Sofia Lim', 'sofia.lim@email.com', '+63 917 758 1143', 'First booking', 'New Guest', 'Active'),
    ('CUS-2004', 'Mark Anthony Tan', 'mark.tan@email.com', '+63 919 330 6217', 'May 3-5, 2026', 'Loyalty Member', 'Active'),
    ('CUS-2005', 'Patricia Gomez', 'patricia.gomez@email.com', '+63 917 894 5006', 'April 15-17, 2026', 'Returning Guest', 'Inactive')
ON DUPLICATE KEY UPDATE name = VALUES(name), email = VALUES(email), phone = VALUES(phone), last_stay = VALUES(last_stay), guest_type = VALUES(guest_type), status = VALUES(status);

INSERT INTO services (service_id, service_name, category, duration, price, status) VALUES
    ('SER-3001', 'Private Pool Access', 'Recreation', 'Full day', 2500.00, 'Available'),
    ('SER-3002', 'Hilot Massage', 'Spa and Wellness', '60 minutes', 1800.00, 'Available'),
    ('SER-3003', 'Sunset Dinner', 'Dining', '2 hours', 3200.00, 'Available'),
    ('SER-3004', 'Airport Transfer', 'Transport', 'One way', 1500.00, 'Available'),
    ('SER-3005', 'Island Hopping Tour', 'Tours', 'Full day', 4500.00, 'Limited')
ON DUPLICATE KEY UPDATE service_name = VALUES(service_name), category = VALUES(category), duration = VALUES(duration), price = VALUES(price), status = VALUES(status);

SELECT * FROM staff;
SELECT * FROM customers;
SELECT * FROM services;
