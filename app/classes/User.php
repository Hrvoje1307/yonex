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

        echo $this->cardPrint($products, $category);
    }

    private function cardPrint($array, $category) {
        $code = "";
        foreach($array as $product) {
            if($product["category"] == $category || $category == "search") {
                $code.= "
                <div class='card shop__card'>
                <a href='product.php?data=".$product['id']."'>
                    <img src='".$product['img_url']."' class='card-img-top' alt='".$product['description']."'>
                    <div class='card-body'>
                        <h5 class='card-title fw-bold'>".$product['name']."</h5>
                        <p class='card-text'>".$this->truncString($product['description'])." </p>
                        <p class='fs-3 m-0'><span>".$product['price']."</span>€</p>
                        <p class='fs-5 m-0 mb-3'><span>".$product['priceNOTAX']."</span>€</p>
                        ";
            if($product["quantity"]>0) {
                    $code.="
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
                $code.="
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
            $code.= " </div></a>
            </div> ";
            }
        }
        return $code;
    }

    

    private function truncString($string, $length = 100, $append="...") {
        if(strlen($string) > $length) {
            $string =substr($string,0,$length).$append;
        }
        return $string;
    }

    public function searchResults() {
        if(isset($_POST["submit-search"])) {
            $search_input = $_POST["search-input"];

            $sql = "(
                SELECT id, name, price, priceNOTAX, quantity, img_url, description FROM classicfilters WHERE id LIKE ? OR name LIKE ?
            ) UNION (
                SELECT id, name, price, priceNOTAX, quantity, img_url, description FROM bags WHERE id LIKE ? OR name LIKE ?
            ) UNION (
                SELECT id, name, price, priceNOTAX, quantity, img_url, description FROM balls WHERE id LIKE ? OR name LIKE ?
            ) UNION (
                SELECT id, name, price, priceNOTAX, quantity, img_url, description FROM clothing WHERE id LIKE ? OR name LIKE ?
            ) UNION (
                SELECT id, name, price, priceNOTAX, quantity, img_url, description FROM cords WHERE id LIKE ? OR name LIKE ?
            ) UNION (
                SELECT id, name, price, priceNOTAX, quantity, img_url, description FROM rackets WHERE id LIKE ? OR name LIKE ?
            ) UNION (
                SELECT id, name, price, priceNOTAX, quantity, img_url, description FROM shoes WHERE id LIKE ? OR name LIKE ?
            )";            
            $stmt = $this->conn->prepare($sql);
            $search_pattern = "%$search_input%";
            $stmt->bind_param("ssssssssssssss", $search_pattern,$search_pattern, $search_pattern, $search_pattern, $search_pattern, $search_pattern, $search_pattern, $search_pattern, $search_pattern, $search_pattern, $search_pattern, $search_pattern, $search_pattern, $search_pattern     );
            $stmt->execute();
            $results = $stmt->get_result();
            $products = array();
        
            if ($results->num_rows > 0) {
                while ($row = $results->fetch_assoc()) {
                    $products[] = $row;
                }
                $_SESSION["search_result"] = $this->cardPrint($products, "search");
            }
            header("Location: ./search.php");
            exit();
        }
    }

    public function singleProduct() {
        $data_id = isset($_GET["data"]) ? $_GET["data"] : null;

        if($data_id) {
            $sql = "(
                SELECT id, name, price, priceNOTAX, quantity, img_url, description FROM classicfilters WHERE id=?
            ) UNION (
                SELECT id, name, price, priceNOTAX, quantity, img_url, description FROM bags WHERE id=?
            ) UNION (
                SELECT id, name, price, priceNOTAX, quantity, img_url, description FROM balls WHERE id=?
            ) UNION (
                SELECT id, name, price, priceNOTAX, quantity, img_url, description FROM clothing WHERE id=?
            ) UNION (
                SELECT id, name, price, priceNOTAX, quantity, img_url, description FROM cords WHERE id=?
            ) UNION (
                SELECT id, name, price, priceNOTAX, quantity, img_url, description FROM rackets WHERE id=?
            ) UNION (
                SELECT id, name, price, priceNOTAX, quantity, img_url, description FROM shoes WHERE id=?
            )"; 
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("sssssss",$data_id,$data_id,$data_id,$data_id,$data_id,$data_id,$data_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $data = $result->fetch_assoc();
            
            echo $this->productPrint($data);
        }
    }

    private function productPrint($data) {
        $code="";
        $code.= "
        <div class='row mt-3 mb-5 justify-content-md-start justify-content-center'>
            <div class='col-md-6 col-12 mb-3 mb-md-0'>
                <div class='me-5 shadow shadow-sm border border-1 rounded d-flex justify-content-center align-items-center'>
                    <img src='".$data['img_url']."'  class='img-fluid my-5' alt='".$data['description']."'>
                </div>
            </div>
            <div class='col-md-6 col-12'>
            <button class='btn btn-light border border-2'><i class='bi bi-heart'></i></button>
                <h2 class='my-3'>".$data['name']."</h2>
                <p class='mb-1'>Proizvođač: <span class='text-black fw-bold'>Yonex</span></p>
                <p class='mb-1'>Šifra: <span class='text-black fw-bold'>".$data['id']."</span></p>";
        if($data["quantity"]>0) {
            $code.="<p class='mb-1'>Dostupnost: <span class='text-success fw-bold'>Dostupno</span></p>";
        }else {
            $code.="<p class='mb-1'>Dostupnost: <span class='text-danger fw-bold'>Nedostupno</span></p>";
        }
        $code.="
                <h2><span>".$data['price']."</span>€</h2>
                <p class='fw-semibold text-secondary'>Bez PDV-a <span>".$data['priceNOTAX']."</span>€</p>
                <hr>
                <h4>Dostupne mogućnosti</h4>
                <p class='fw-semibold'>Količina</p>
                <input type='number' class='form-control' value='1'>";
        if($data["quantity"]>0) {
            $code.="
                <button class='btn btn-dark d-flex gap-3 mt-3'>
                    <i class='text-light bi bi-cart-fill'></i>
                    <span class='text-light'>Dodaj u košaricu</span>
                </button>";
        }else {
            $code.="
                <button class='btn btn-dark d-flex gap-3 mt-3 disabled'>
                    <i class='text-light bi bi-cart-fill'></i>
                    <span class='text-light'>Dodaj u košaricu</span>
                </button>
            ";
        }      
        $code.="
            </div>
        </div>
        <div>
            <h3>Opis</h3>
            <hr>
            <p>".$data['description']."</p>
        </div>";


        return $code;
    }
}