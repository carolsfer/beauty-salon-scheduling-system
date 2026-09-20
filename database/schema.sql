CREATE DATABASE IF NOT EXISTS salao_leila
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE salao_leila;

CREATE TABLE clients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL UNIQUE
);

CREATE TABLE services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

CREATE TABLE appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_id INT NOT NULL,
    appointment_datetime DATETIME NOT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'PENDING',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (client_id)
        REFERENCES clients(id)
);

CREATE TABLE appointment_services (
    appointment_id INT NOT NULL,
    service_id INT NOT NULL,

    PRIMARY KEY (appointment_id, service_id),

    FOREIGN KEY (appointment_id)
        REFERENCES appointments(id),

    FOREIGN KEY (service_id)
        REFERENCES services(id)
);