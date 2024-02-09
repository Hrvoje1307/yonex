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


    //STORE PRINT PRODUCTS
    public function vibrationDumpers() {
        $sql = "SELECT * FROM classicfilters";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
    
        $results = $stmt->get_result();
        $products = array();
    
        if ($results->num_rows > 0) {
            while ($row = $results->fetch_assoc()) {
                $products[] = $row;
            }
        }

    
        foreach($products as $product) {
            if($product["quantity"]>0) {
                echo "
                <div class='card shop__card'>
                    <img src='".$product['img_url']."' class='card-img-top' alt='".$product['description']."'>
                    <div class='card-body'>
                        <h5 class='card-title fw-bold'>".$product['name']."</h5>
                        <p class='card-text'>".$product['description']." </p>
                        <p class='fs-5 m-0'><span>".$product['price']."</span>€</p>
                        <p class='fs-6 m-0 mb-3'><span>".$product['priceNOTAX']."</span>€</p>
                        <p class='fs-6 fw-semibold text-success m-0 mb-3'>Dostupno</p>
                        <div class='btn-group' role='group' aria-label='Basic radio toggle button group'>
                        <a href='#' class='btn btn-light d-flex gap-1 justify-content-center align-items-center'>
                            <i class='bi bi-cart-fill'></i>
                            <p class='lead m-0'>Dodaj u košaricu</p>
                        </a>
                        <a href='#' class='btn btn-light d-flex gap-1 justify-content-center align-items-center'>
                            <i class='bi bi-heart'></i>
                        </a>
                        </div>
                    </div>
                </div>";
            }
        }
    }

    public function printProductCards($table, $category) {
        $sql = "SELECT * FROM $table";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
    
        $results = $stmt->get_result();
        $products = array();
    
        if ($results->num_rows > 0) {
            while ($row = $results->fetch_assoc()) {
                $products[] = $row;
            }
        }

        $this->cardPrint($products, $category);
    }

    private function cardPrint($array, $category) {
        foreach($array as $product) {
            if($product["category"] == $category) {
                echo "
                <div class='card shop__card'>
                    <img src='".$product['img_url']."' class='card-img-top' alt='".$product['description']."'>
                    <div class='card-body'>
                        <h5 class='card-title fw-bold'>".$product['name']."</h5>
                        <p class='card-text'>".$this->truncString($product['description'])." </p>
                        <p class='fs-3 m-0'><span>".$product['price']."</span>€</p>
                        <p class='fs-5 m-0 mb-3'><span>".$product['priceNOTAX']."</span>€</p>
                        ";
            if($product["quantity"]>0) {
                    echo"
                        <p class='fs-6 fw-semibold text-success m-0 mb-3'>Dostupno</p>
                        <div class='btn-group' role='group' aria-label='Basic radio toggle button group'>
                        <a href='#' class='btn btn-light d-flex gap-1 justify-content-center align-items-center'>
                            <i class='bi bi-cart-fill'></i>
                            <p class='lead m-0'>Dodaj u košaricu</p>
                        </a>
                        <a href='#' class='btn btn-light d-flex gap-1 justify-content-center align-items-center'>
                            <i class='bi bi-heart'></i>
                        </a>
                        </div>";
                   
            }
            else if($product["quantity"]<= 0) {
                echo"
                        <p class='fs-6 fw-semibold text-danger m-0 mb-3'>Nedostupno</p>
                        <div class='btn-group' role='group' aria-label='Basic radio toggle button group'>
                        <a href='#' class='btn btn-light d-flex gap-1 justify-content-center align-items-center disabled'>
                            <i class='bi bi-cart-fill'></i>
                            <p class='lead m-0'>Dodaj u košaricu</p>
                        </a>
                        <a href='#' class='btn btn-light d-flex gap-1 justify-content-center align-items-center disabled'>
                            <i class='bi bi-heart'></i>
                        </a>
                        </div>
                ";
            }
            echo " </div>
            </div>";
            }
        }
    }

    private function truncString($string, $length = 100, $append="...") {
        if(strlen($string) > $length) {
            $string =substr($string,0,$length).$append;
        }
        return $string;
    }


}