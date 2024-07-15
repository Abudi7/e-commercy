<?php

require 'Database.php'; // Assuming Database.php contains the Database class for connection

class Cart {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    // Method to fetch cart items for a specific user
    public function getCartItems($user_id) {
      $query = "SELECT cart.id, products.name, products.price, products.image, cart.quantity
                FROM cart
                INNER JOIN products ON cart.product_id = products.id
                WHERE cart.user_id = ?";
      $stmt = $this->conn->prepare($query);
      $stmt->bind_param("i", $user_id);
      $stmt->execute();
      $result = $stmt->get_result();
      $cartItems = [];
      while ($row = $result->fetch_assoc()) {
          $cartItems[] = $row;
      }
      return $cartItems;
  }
  

     // Method to update quantity of a cart item
     public function updateCartItemQuantity($cart_id, $new_quantity) {
      $query = "UPDATE cart SET quantity = ? WHERE id = ?";
      $stmt = $this->conn->prepare($query);
      $stmt->bind_param("ii", $new_quantity, $cart_id);
      return $stmt->execute();
  }

    // Method to add item to cart
    public function addToCart($user_id, $product_id, $quantity, $createdAt) {
    // Format the DateTime object as a string in 'yyyy-mm-dd HH:ii:ss' format
    $created_at = $createdAt->format('Y-m-d H:i:s');
    
    $query = "INSERT INTO cart (user_id, product_id, quantity, created_at) VALUES (?, ?, ?, ?)";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("iiis", $user_id, $product_id, $quantity, $created_at);
    return $stmt->execute();
  }


   // Method in Cart class (../Class/Cart.php)
    public function removeFromCart($cart_id) {
      $query = "DELETE FROM cart WHERE id = ?";
      $stmt = $this->conn->prepare($query);
      $stmt->bind_param("i", $cart_id);
      $stmt->execute();
      return $stmt->affected_rows > 0;
    }

}
?>
