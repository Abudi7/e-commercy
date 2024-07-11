<?php

require_once 'Database.php';
class Login {
    private $db;
    private $conn;
    private $message;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
        $this->message = '';
    }

    public function loginUser($email, $password) {
      if ($this->conn) {
          $email = htmlspecialchars(trim($email));
          $password = htmlspecialchars(trim($password));

          if (empty($email) || empty($password)) {
              $this->message = "All fields are required.";
              return;
          }

          if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
              $this->message = "Invalid email format.";
              return;
          }
          // Prepare our SQL, preparing the SQL statement will prevent SQL injection.
          $stmt = $this->conn->prepare("SELECT id, password, firstname, lastname, role  FROM users WHERE email = ?");
          if ($stmt) {
            	// Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
              $stmt->bind_param('s', $email);
              $stmt->execute();

              // Store the result so we can check if the account exists in the database.
              $stmt->store_result();

              if ($stmt->num_rows === 1) {
                  $stmt->bind_result($id, $hashed_password, $firstname, $lastname,$role);
                  $stmt->fetch();

                  if (password_verify($password, $hashed_password)) {
                      $_SESSION['loggedin'] = true;
                      $_SESSION['id'] = $id;
                      $_SESSION['email'] = $email;
                      $_SESSION['firstname'] = $firstname;
                      $_SESSION['lastname'] = $lastname;
                      $_SESSION['role'] = $role;
                      //$this->message = "Login successful!";
                      header('Location: ../index.php');
                  } else {
                      $this->message = "Invalid password.";
                  }
              } else {
                  $this->message = "No account found with that email.";
              }
              $stmt->close();
          } else {
              $this->message = "Database query error.";
          }
      } else {
          $this->message = "Database connection error.";
      }
  }

  public function getMessage() {
      return $this->message;
  }
}
?>
