-- Schema for avaliacao_titan
CREATE DATABASE IF NOT EXISTS avaliacao_titan CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE avaliacao_titan;

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(180) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS services (
  id INT AUTO_INCREMENT PRIMARY KEY,
  description TEXT NOT NULL,
  value DECIMAL(12,2) NOT NULL,
  status ENUM('Pendente','Finalizado') NOT NULL DEFAULT 'Pendente',
  user_id INT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  finished_at TIMESTAMP NULL DEFAULT NULL,
  commission DECIMAL(12,2) NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Seed example: create an admin user. Replace PASSWORD_HASH with output of password_hash('senha123', PASSWORD_DEFAULT)
-- INSERT INTO users (name, email, password) VALUES ('Admin Teste', 'admin@titan.local', 'PASSWORD_HASH');
