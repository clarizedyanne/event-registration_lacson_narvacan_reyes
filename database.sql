-- ============================================
-- SEVENTEEN Event Registration System
-- ============================================
-- Events Table (UPDATED to support 3 price tiers)
CREATE TABLE events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_name VARCHAR(150) NOT NULL,
    venue VARCHAR(150) NOT NULL,
    event_date DATE NOT NULL,
    price_vip DECIMAL(10,2) NOT NULL,
    price_floorpit DECIMAL(10,2) NOT NULL,
    price_general DECIMAL(10,2) NOT NULL,
    slots_available INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Registrations Table
CREATE TABLE registrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    event_id INT NOT NULL,
    ticket_type VARCHAR(50) NOT NULL,
    registered_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE
);

-- Admin Login Table
CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- Default Admin (username: admin | password: admin123)
INSERT INTO admins (username, password)
VALUES ('admin', '$2y$10$e0NRm7dZg1Q1k1z1z1z1zOQwKfH1z1z1z1z1z1z1z1z1z1z1z1z1');

-- Sample Events (UPDATED with 3 price tiers)
INSERT INTO events (event_name, venue, event_date, price_vip, price_floorpit, price_general, slots_available) VALUES
('SEVENTEEN FOLLOW Tour Manila', 'Philippine Arena, Bulacan', '2025-08-15', 18000.00, 13000.00, 5000.00, 200),
('SVT Fan Meet Manila', 'Mall of Asia Arena, Pasay', '2025-09-20', 10000.00, 7000.00, 3000.00, 150),
('SEVENTEEN BE THE SUN - Manila Encore', 'Araneta Coliseum, Quezon City', '2025-11-05', 15000.00, 10000.00, 4500.00, 100);