<?php 

class User {
    protected $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    

    // registracija
    public function create($name, $surname, $email, $number, $password) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
        $sql = "INSERT INTO users (name, surname, email, number, password) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssss", $name, $surname, $email, $number, $hashed_password);
        
    
        $result = $stmt->execute();
    
        if ($result) {
            $_SESSION['user_id'] = $stmt->insert_id;
            return true;
        } else {
            return false;
        }
    }

    // prijava
    public function login($email, $password) {
        $sql = "SELECT user_id, password FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $results = $stmt->get_result();

        if ($results->num_rows == 1) {
            $user = $results->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['user_id'];
                return true;
            }
        }

        return false;
    }
    
    // provjera ulogiranosti
    public function is_logged() {
        if(isset($_SESSION['user_id'])) {
            return true;
        }
        return false;
    }

    // odjava
    public function logout() {
        unset($_SESSION['user_id']);
    }

    // provjera postojanosti maila
    public function emailExists($email) {
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) return true;

        return false;
    }

    // provjera postojanosti broja
    public function numberExists($number) {
        $sql = "SELECT * FROM users WHERE number = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $number);
        $stmt->execute();

        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) return true;

        return false;
    }
}