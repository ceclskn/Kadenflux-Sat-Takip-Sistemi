CREATE TABLE sales(
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    product_name VARCHAR(100),
    customer_name VARCHAR(100),
    price DECIMAL (10,2),
    sale_date DATE,
    FOREIGN KEY (user_id) REFERENCES users(id)  );