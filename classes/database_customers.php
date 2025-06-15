<?php

class database_customers {
    private $conn;

    public function __construct() {
        try {
            $this->conn = new PDO('mysql:host=localhost;dbname=cof_shop', 'root', '');
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    // ✅ SIGNUP with duplicate check + image
    public function signupUser($firstname, $lastname, $username, $email, $password, $profileImage = '') {
    try {
        $stmt = $this->conn->prepare("INSERT INTO customers (customer_FN, customer_LN, customer_username, customer_email, customer_password, profile_image) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$firstname, $lastname, $username, $email, $password, $profileImage]);
        return $this->conn->lastInsertId();
    } catch (PDOException $e) {
        return false;
    }
}


    // ✅ Check if username exists
    public function isUsernameExists($username) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM customers WHERE customer_username = ?");
        $stmt->execute([$username]);
        return $stmt->fetchColumn() > 0;
    }

    // ✅ Check if email exists
    public function isEmailExists($email) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM customers WHERE customer_email = ?");
        $stmt->execute([$email]);
        return $stmt->fetchColumn() > 0;
    }

    // ✅ Login securely
    public function loginUser($username, $password) {
        $stmt = $this->conn->prepare("SELECT * FROM customers WHERE customer_username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['customer_password'])) {
            return $user;
        }
        return false;
    }

    public function getConnection() {
    return $this->conn;
}

}
?>
