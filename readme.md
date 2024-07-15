# Documantion
1. Requirements and Database Design
1.1 Expanding Customer Base
•	Goal: Develop a web shop application to reach a broader customer base.
1.2 Database Design
•	Tables:
o	users (id, username, password, email, role)
o	products (id, name, description, price, image)
o	orders (id, user_id, total_price, created_at)
o	order_items (id, order_id, product_id, quantity, price)
1.3 Time Estimation
•	Planning and Design: 2 days
•	Database Design: 1 day
•	Function Implementation: 5 days
•	Testing and Debugging: 2 days
•	Documentation: 1 day
•	Total: approx. 11 days
2. Sketch and GUI Design
•	Sketch: Draw a simple user interface for the web shop.
•	GUI: Simple, user-friendly design without absolute positioning.
3. Product Listing and Management
•	List of products with name, image, and price.
•	Detailed view of a product with all properties.
4. Admin Area
•	Admin login-logout.
•	CRUD (Create, Read, Update, Delete) operations for products.
•	Statistics on the most and least sold products.
5. Security Measures
•	Prevent SQL injection using prepared statements.
•	Password hashing (e.g., with password_hash).
•	Session management for admin login.
•	Do not use root in the database, create a new user.


## users Table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    firstname VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    role ENUM('customer', 'admin') NOT NULL DEFAULT 'customer',
    createdat TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
## products Table
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    image_url VARCHAR(255)
);
## orders Table
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('pending', 'processing', 'completed', 'cancelled') NOT NULL DEFAULT 'pending',
    total_amount DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
Relationship: One user (user_id) can have multiple orders (orders).
## order_items Table
CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    unit_price DECIMAL(10, 2) NOT NULL,
    address_id INT,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (product_id) REFERENCES products(id),
    FOREIGN KEY (address_id) REFERENCES addresses(id)
);
Relationship: Each order (order_id) can contain multiple order items (order_items).

## addresses Table
CREATE TABLE addresses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    type ENUM('billing', 'shipping') NOT NULL,
    address_line1 VARCHAR(255) NOT NULL,
    address_line2 VARCHAR(255),
    city VARCHAR(100) NOT NULL,
    postal_code VARCHAR(20) NOT NULL,
    country VARCHAR(100) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
Relationship: Each user (user_id) can have multiple addresses (addresses), differentiated by type (billing or shipping).