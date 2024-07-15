<?php
require 'Database.php';

class Products {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function create($name, $description, $price, $image) {
        $stmt = $this->conn->prepare("INSERT INTO products (name, description, price, image) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('ssds', $name, $description, $price, $image);
        return $stmt->execute();
    }

    public function read() {
        $stmt = $this->conn->prepare("SELECT * FROM products");
        $stmt->execute();
        return $stmt->get_result();
    }
    public function view($id) {
      $stmt = $this->conn->prepare("SELECT * FROM products WHERE id = ?");
      $stmt->bind_param('i', $id);
      if ($stmt->execute()) {
          $result = $stmt->get_result();
          if ($result->num_rows > 0) {
              return $result->fetch_assoc();
          } else {
              return null; // No product found with the given ID
          }
      } else {
          // Handle query execution error
          return null; // Error executing the query
      }
  }
  

    public function update($id, $name, $description, $price, $image) {
        $stmt = $this->conn->prepare("UPDATE products SET name = ?, description = ?, price = ?, image = ? WHERE id = ?");
        $stmt->bind_param('ssdsi', $name, $description, $price, $image, $id);
        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM products WHERE id = ?");
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }

    public function getProductById($id) {
      $stmt = $this->conn->prepare("SELECT * FROM products WHERE id = ?");
      $stmt->bind_param('i', $id);
      if ($stmt->execute()) {
          $result = $stmt->get_result();
          if ($result->num_rows > 0) {
              return $result->fetch_assoc();
          } else {
              return null; // No product found with the given ID
          }
      } else {
          return null; // Error executing the query
      }
  }
  
}
?>
