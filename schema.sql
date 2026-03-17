CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE items (
    item_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    item_name VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    status ENUM('lost','found','claimed') DEFAULT 'found',
    location VARCHAR(255) NOT NULL,
    date_reported DATE NOT NULL,
    image VARCHAR(255),
    reported_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    claimed_by INT DEFAULT NULL,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE SET NULL,
    FOREIGN KEY (claimed_by) REFERENCES users(user_id) ON DELETE SET NULL
);

CREATE TABLE claims (
    claim_id INT AUTO_INCREMENT PRIMARY KEY,
    item_id INT NOT NULL,
    user_id INT NOT NULL,
    claim_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (item_id) REFERENCES items(item_id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);