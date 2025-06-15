<?php

class adminDatabase {
    private $conn;

    public function __construct() {
        try {
            $this->conn = new PDO("mysql:host=localhost;dbname=cof_shop", "root", "");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public function signupAdmin($firstname, $lastname, $username, $email, $password) {
        try {
            $this->conn->beginTransaction();

            $stmt = $this->conn->prepare("INSERT INTO admin (admin_FN, admin_LN, admin_username, admin_email, admin_password) VALUES (?, ?, ?, ?, ?)");

            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            $stmt->execute([$firstname, $lastname, $username, $email, $hashedPassword]);

            $adminId = $this->conn->lastInsertId();
            $this->conn->commit();

            return $adminId;
        } catch (PDOException $e) {
            $this->conn->rollBack();
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function isUsernameExists($username) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM admin WHERE admin_username = ?");
        $stmt->execute([$username]);
        return $stmt->fetchColumn() > 0;
    }

    public function isEmailExists($email) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM admin WHERE admin_email = ?");
        $stmt->execute([$email]);
        return $stmt->fetchColumn() > 0;
    }

    public function loginAdmin($username, $password) {
        $stmt = $this->conn->prepare("SELECT * FROM admin WHERE admin_username = ?");
        $stmt->execute([$username]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin && password_verify($password, $admin['admin_password'])) {
            return $admin;
        }

        return false;
    }

    public function getAllCustomers() {
        $stmt = $this->conn->prepare("SELECT * FROM customers ORDER BY created_at DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllOrders() {
        $stmt = $this->conn->prepare("SELECT * FROM orders ORDER BY created_at DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOrdersWithCustomerInfo() {
        $stmt = $this->conn->prepare("
            SELECT 
                o.order_ID,
                o.order_type,
                o.created_at AS order_date,
                o.status,
                o.payment_method,
                o.screenshot_path,
                c.customer_ID,
                c.customer_FN,
                c.customer_LN,
                c.customer_username,
                c.customer_email
            FROM orders o
            JOIN customers c ON o.customer_ID = c.customer_ID
            ORDER BY o.created_at DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getConnection() {
    return $this->conn;
}

}
?>
