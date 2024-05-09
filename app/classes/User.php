<?php 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class User {
    protected $conn;
    private $minValue = 0;
    private $maxValue = 1000;

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
            unset($_SESSION["name"]);
            $_SESSION['name'] = $name;
            return true;
        } else {
            return false;
        }
    }

    // prijava
    public function login($email, $password) {
        $sql = "SELECT user_id, password,name FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $results = $stmt->get_result();

        if ($results->num_rows == 1) {
            $user = $results->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION["name"] = $user["name"];
                return true;
            }
        }

        return false;
    }

    public function fillData($userId) {
        $sql = "SELECT * from users WHERE user_id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s",$userId);
        $stmt->execute();
        $results = $stmt->get_result();
        if($results->num_rows == 1) {
            return $results->fetch_assoc();
        }
    }

    public function changeData() {
        $counter = 0;
        unset($_SESSION["message"]["type"]);
        unset($_SESSION["message"]["text"]);
        if($_SERVER["REQUEST_METHOD"]=="POST") {
            $name = ["value" => $_POST['name'], "field" => "name"];
            $surname = ["value" => $_POST['surname'], "field" => "surname"];
            $email = ["value" => $_POST["email"], "field" => "email"];
            $phone = ["value" => $_POST["phone-number"], "field" => "number"];
            $oldPassword = $_POST["old-password"];
            $newPassword = $_POST["new-password"];
            $newRepPassword = $_POST["new-password-repeted"];
            $inputChangeArray =  [$name,$surname,$email,$phone];
            if($_SESSION["name"]) {
                $sql = "SELECT * FROM users where user_id=?";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("s",$_SESSION["user_id"]);
                $stmt->execute();
                $results = $stmt->get_result();
                if($results->num_rows==1) {
                    $data = $results->fetch_assoc();
                    if(isset($oldPassword) && password_verify($oldPassword,$data["password"])) {
                        foreach($inputChangeArray as $field) {
                            if($field["value"] !== $data[$field["field"]]) {
                                $sql = "UPDATE users SET ".$field['field']."=? WHERE user_id=?";
                                $stmt = $this->conn->prepare($sql);
                                $stmt->bind_param("ss", $field["value"], $_SESSION["user_id"]);
                                $stmt->execute();
                                $_SESSION["name"] = $name["value"];
                                $counter++;
                            }
                        }
                        if(isset($newPassword) && $this->passwordCheck($newPassword,$newRepPassword)) {
                            $inputPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                            $sql = "UPDATE users SET password=? WHERE user_id=?";
                            $stmt = $this->conn->prepare($sql);
                            $stmt->bind_param("ss", $inputPassword, $_SESSION["user_id"]);
                            $stmt->execute();
                            $counter++;
                        }
                        if($counter > 0) {
                            $_SESSION["message"]["type"] = "success";
                            $_SESSION["message"]["text"] = "Uspiješno ste promijenili podatke";
                        }else {
                            $_SESSION["message"]["type"] = "danger";
                            $_SESSION["message"]["text"] = "Niste promijenili nijedno polje. Pokušajte ponovno";
                        }
                    }else {
                        $_SESSION["message"]["type"] = "danger";
                        $_SESSION["message"]["text"] = "Pogrešna lozinka. Pokušajte ponovno";
                    }
                }
            }
        }
    }

    public function getMail() {
        unset($_SESSION["message"]["type"]);
        unset($_SESSION["message"]["text"]);
        if($_SERVER["REQUEST_METHOD"]=="POST") {
            $email = $_POST["email"];
            $token = bin2hex(random_bytes(16));
            $token_hash = hash("sha256", $token);
            $expiry = date("Y-m-d H:i:s", strtotime("+5 minutes"));
            $sql = "UPDATE users
                        SET reset_token_hash =?, reset_token_expires_at = ?
                    WHERE email = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("sss", $token_hash, $expiry, $email);
            $stmt->execute();

            if($this->conn->affected_rows) {
               $mail = $this->smtpServer();
               $mail->setFrom("noreplay@gmail.com");
               $mail->addAddress($email);
               $mail->Subject = "Resetiranje lozinke";
               $mail->Body ="Kliknite http://localhost/yonex/reset-password.php?token=$token za resetiranje lozinke";
               try{
                $mail->send();
               }catch(Exception $e) {
                    $_SESSION["message"]["type"]="danger";
                    $_SESSION["message"]["text"]="Poruku nije moguće poslati jer {$mail->ErrorInfo}";
               }
            }
            $_SESSION["message"]["type"]="success";
            $_SESSION["message"]["text"]="Poveznica je uspijesno poslana";
        }
    }

    private function smtpServer() {
        require __DIR__ . "/../../vendor/autoload.php";
    
        $mail = new PHPMailer(true);
    
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->isSMTP();
        $mail->SMTPAuth = true;
    
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->Username="cuckovichrvoje@gmail.com";
        $mail->Password="mcws yeke qjzo dlbn";
        return $mail;
    }

    public function tokenPassword() {
        $token = $_GET["token"];

        $token_hash = hash("sha256", $token);
        $sql = "SELECT * from users WHERE reset_token_hash = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $token_hash);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if(!$user) {
            die("Token nije pronađen");
        }else if(strtotime($user["reset_token_expires_at"])<=time()) {
            die("Token je istekao");
        }else {
            return true;
        }
    }

    public function changePassword() {
        unset($_SESSION["message"]["type"]);
        unset($_SESSION["message"]["text"]);
        $token_hash = hash("sha256", $_GET["token"]);
        
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $password = $_POST["new_password"];
            $passworEnc = password_hash($password, PASSWORD_DEFAULT);
            $repetedPassword = $_POST["new_password_repeated"];
            $passwordChecked = $this->passwordCheck($password,$repetedPassword);
            if($passwordChecked) {
                $sql = "UPDATE users SET password=? WHERE reset_token_hash=?";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("ss", $passworEnc, $token_hash);
                $stmt->execute();
                $_SESSION["message"]["type"] = "success";
                $_SESSION["message"]["text"] = "Uspiješno ste promijenili lozinku idite na <a href='login.php' class='text-decoration-underline'>prijava</a> i prijavite se ponovo";
            }
            // return $password;
        }
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

    public function passwordCheck($password, $repetedPassword=null) {
        $uppercase = preg_match("@[A-Z]@", $password);
        $lowercase = preg_match("@[a-z]@", $password);
        $number = preg_match("@[0-9]@", $password);
        $specialCharacter = preg_match('@[^\w]@',$password);

        if(!$uppercase || !$lowercase || !$number || !$specialCharacter || strlen($password) < 9) {
            return false;
        }else {
            if($repetedPassword) {
                if($password != $repetedPassword) {
                    return false;
                }else {
                    return true;
                }
            }
            return true;
        }
    }


    //STORE PRINT PRODUCTS
    // public function printProductCards($category, $array) {
    //     echo $this->cardPrint($array, $category);
    // }

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

    // Filters
    private function checkboxFilterPrint($results, $filterName) {
        $arrName = $filterName ."[]";
        if($results->num_rows>=1) {
            while($data = $results->fetch_assoc()) {
                $checked = [];
                if(isset($_GET[$filterName])) {
                    $checked = $_GET[$filterName];
                }
                echo "
                    <li class='d-flex gap-2 align-items-center list-group-item border border-0'>
                        <input type='checkbox' name='".$arrName."' id='".$data["content"]."' value='".$data['content']."'";

                if(in_array($data["content"], $checked)) {
                    echo "checked";
                }
                        
                echo ">
                        <label for='".$data["content"]."'>".$data['content']."</label>
                    </li>
                ";
            }
        }
    }

    private function getDataWithOneCondition($table, $condition) {
        $sql = "SELECT * FROM $table WHERE category = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s",$condition);
        $stmt->execute();
        $results = $stmt->get_result();
        return $results;
    }

    public function availabilityFilter() {
        $sql = "SELECT * FROM availability";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $results = $stmt->get_result();
        $this->checkboxFilterPrint($results,"filterAvailability");
    }

    public function racketWeight($sport) {
        $results = $this->getDataWithOneCondition("racket_weight",$sport);
        $this->checkboxFilterPrint($results,"filterRacketWeight");
    }

    public function racketType($sport) {
        $results = $this->getDataWithOneCondition("racket_type",$sport);
        $this->checkboxFilterPrint($results,"filterRacketType");
    }

    public function handleType($sport) {
        $results = $this->getDataWithOneCondition("handle_type",$sport);
        $this->checkboxFilterPrint($results,"filterHandleType");
    }

    public function shoesSize($sport) {
        $results = $this->getDataWithOneCondition("shoes_size",$sport);
        $this->checkboxFilterPrint($results,"filterShoesSize");
    }

    public function genderFilter($sport) {
        $results = $this->getDataWithOneCondition("gender",$sport);
        $this->checkboxFilterPrint($results,"filterGender");
    }

    public function cordWidth($sport) {
        $results = $this->getDataWithOneCondition("cord_width",$sport);
        $this->checkboxFilterPrint($results,"filterCordWidth");
    }

    public function cordLength($sport) {
        $results = $this->getDataWithOneCondition("cord_length",$sport);
        $this->checkboxFilterPrint($results,"filterCordLength");
    }

    public function priceFilter() {
        if(isset($_GET["filterPrice"])) {
            isset($_GET["filterPrice"][0]) ? $this->minValue = $_GET["filterPrice"][0] : $this->minValue;
            isset($_GET["filterPrice"][1]) ? $this->maxValue = $_GET["filterPrice"][1] : $this->maxValue;
        }

        echo "
            <br>
            <input type='number' style='width:40%' name='filterPrice[]' min=0 value=".$this->minValue.">
            <p class='fw-semibold mb-0 text-nowrap'>€ -</p>
            <input type='number' style='width:40%' name='filterPrice[]' value=".$this->maxValue.">
            <p class='fw-semibold mb-0'>€</p>
        ";  

    }

    // Printing products based on filters
    public function printClassicFilters($table,$category) {
        $products = [];
        $additionalSql = [];
        $available = false;
        $unavailable = false;
        $minPrice = isset($_GET["filterPrice"][0]) ? +$_GET["filterPrice"][0] : $this->minValue;
        $maxPrice = isset($_GET["filterPrice"][1]) ? +$_GET["filterPrice"][1] : $this->maxValue;
        if(isset($_GET["filterAvailability"])) {
            $filterAvailability = $_GET["filterAvailability"];
            $available = in_array("Dostupno",$filterAvailability);
            $unavailable = in_array("Nedostupno",$filterAvailability);
            if($available || $unavailable) {
                if($available && $unavailable) {
                    array_push($additionalSql, ""); 
                }else {
                    !$available ?: array_push($additionalSql, "AND quantity>0"); 
                    !$unavailable ?: array_push($additionalSql, "AND quantity=0");
                }
            }
        }
        $sql = "SELECT * from $table WHERE category = ? AND price>= ? AND price<= ? ".implode(" ",$additionalSql);
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sdd", $category, $minPrice, $maxPrice);
        $stmt->execute();
        $results = $stmt->get_result();
        while($data = $results->fetch_assoc()) {
            $products[] = $data;
        }
        if(count($products)) {
            echo $this->cardPrint($products, $category);
        }else {
            echo "
            <div class='d-flex justify-content-center align-items-center flex-column'>
                <i class='text-danger fs-2 bi bi-ban'></i>
                <p class='text-danger fs-2'>Nismo pronašli ništa!</p>
            </div>
            ";
        }
    }

    public function printRacketFilters($table, $category) {
        $products = [];
        $additionalSql = [];
        $available = false;
        $unavailable = false;
        $minPrice = isset($_GET["filterPrice"][0]) ? +$_GET["filterPrice"][0] : $this->minValue;
        $maxPrice = isset($_GET["filterPrice"][1]) ? +$_GET["filterPrice"][1] : $this->maxValue;
        $weightArr = isset($_GET["filterRacketWeight"]) ? $_GET["filterRacketWeight"] : null;
        $typeArr = isset($_GET["filterRacketType"]) ? $_GET["filterRacketType"] : null;
        $handlerArr = isset($_GET["filterHandleType"]) ? $_GET["filterHandleType"] : null;
        if(isset($_GET["filterAvailability"])) {
            $filterAvailability = $_GET["filterAvailability"];
            $available = in_array("Dostupno",$filterAvailability);
            $unavailable = in_array("Nedostupno",$filterAvailability);
            if($available || $unavailable) {
                if($available && $unavailable) {
                    array_push($additionalSql, ""); 
                }else {
                    !$available ?: array_push($additionalSql, "AND quantity>0"); 
                    !$unavailable ?: array_push($additionalSql, "AND quantity=0");
                }
            }
        }

        if(isset($_GET["filterRacketWeight"])) {
            foreach ($weightArr as $key => $weight) {
                array_push($additionalSql, "AND racketWeigth = ?");
            }
        }

        if(isset($_GET["filterRacketType"])) {
            foreach ($typeArr as $key => $type) {
                array_push($additionalSql, "AND racketType = ?");
            }
        }

        if(isset($_GET["filterHandleType"])) {
            foreach ($handlerArr as $key => $handler) {
                array_push($additionalSql, "AND handlerSize = ?");
            }
        }
        
        $paramTypes = "ssd";
        $paramValues = [$category, $minPrice, $maxPrice]; 
        $sql = "SELECT * from $table WHERE category = ? AND price>= ? AND price<= ? ".implode(" ",$additionalSql);
        $stmt = $this->conn->prepare($sql);

        if($weightArr) {
            foreach ($weightArr as $weight) {
                $paramTypes .= "s";
                array_push($paramValues, $weight);
            }
        }
        if($typeArr) {
            foreach ($typeArr as $type) {
                $paramTypes .= "s";
                array_push($paramValues, $type);
            }
        }
        if($handlerArr) {
            foreach ($handlerArr as $handler) {
                $paramTypes .= "s";
                array_push($paramValues, $handler);
            }
        }
        $stmt->bind_param($paramTypes, ...$paramValues);
        $stmt->execute();
        $results = $stmt->get_result();
        while($data = $results->fetch_assoc()) {
            $products[] = $data;
        }
        if(count($products)) {
            echo $this->cardPrint($products, $category);
        }else {
            echo "
            <div class='d-flex justify-content-center align-items-center flex-column'>
                <i class='text-danger fs-2 bi bi-ban'></i>
                <p class='text-danger fs-2'>Nismo pronašli ništa!</p>
            </div>
            ";
        }
    }

    public function printShoesFilters($table, $category) {
        $products = [];
        $additionalSql = [];
        $available = false;
        $unavailable = false;
        $minPrice = isset($_GET["filterPrice"][0]) ? +$_GET["filterPrice"][0] : $this->minValue;
        $maxPrice = isset($_GET["filterPrice"][1]) ? +$_GET["filterPrice"][1] : $this->maxValue;
        $sizeArr = isset($_GET["filterShoesSize"]) ? $_GET["filterShoesSize"] : null;
        $genderArr = isset($_GET["filterGender"]) ? $_GET["filterGender"] : null;
        if(isset($_GET["filterAvailability"])) {
            $filterAvailability = $_GET["filterAvailability"];
            $available = in_array("Dostupno",$filterAvailability);
            $unavailable = in_array("Nedostupno",$filterAvailability);
            if($available || $unavailable) {
                if($available && $unavailable) {
                    array_push($additionalSql, ""); 
                }else {
                    !$available ?: array_push($additionalSql, "AND quantity>0"); 
                    !$unavailable ?: array_push($additionalSql, "AND quantity=0");
                }
            }
        }

        if(isset($_GET["filterShoesSize"])) {
            foreach ($sizeArr as $key => $size) {
                array_push($additionalSql, "AND shoes_num = ?");
            }
        }

        if(isset($_GET["filterGender"])) {
            foreach ($handlerArr as $key => $handler) {
                array_push($additionalSql, "AND sex = ?");
            }
        }
        
        $paramTypes = "ssd";
        $paramValues = [$category, $minPrice, $maxPrice]; 
        $sql = "SELECT * from $table WHERE category = ? AND price>= ? AND price<= ? ".implode(" ",$additionalSql);
        $stmt = $this->conn->prepare($sql);

        if($sizeArr) {
            foreach ($sizeArr as $size) {
                $paramTypes .= "s";
                array_push($paramValues, $size);
            }
        }
        if($genderArr) {
            foreach ($genderArr as $gender) {
                $paramTypes .= "s";
                array_push($paramValues, $gender);
            }
        }
        $stmt->bind_param($paramTypes, ...$paramValues);
        $stmt->execute();
        $results = $stmt->get_result();
        while($data = $results->fetch_assoc()) {
            $products[] = $data;
        }
        if(count($products)) {
            echo $this->cardPrint($products, $category);
        }else {
            echo "
            <div class='d-flex justify-content-center align-items-center flex-column'>
                <i class='text-danger fs-2 bi bi-ban'></i>
                <p class='text-danger fs-2'>Nismo pronašli ništa!</p>
            </div>
            ";
        }
    }

    public function printCordsFilters($table, $category) {
        $products = [];
        $additionalSql = [];
        $available = false;
        $unavailable = false;
        $minPrice = isset($_GET["filterPrice"][0]) ? +$_GET["filterPrice"][0] : $this->minValue;
        $maxPrice = isset($_GET["filterPrice"][1]) ? +$_GET["filterPrice"][1] : $this->maxValue;
        $widthArr = isset($_GET["filterCordWidth"]) ? $_GET["filterCordWidth"] : null;
        $lengthArr = isset($_GET["filterCordLength"]) ? $_GET["filterCordLength"] : null;
        if(isset($_GET["filterAvailability"])) {
            $filterAvailability = $_GET["filterAvailability"];
            $available = in_array("Dostupno",$filterAvailability);
            $unavailable = in_array("Nedostupno",$filterAvailability);
            if($available || $unavailable) {
                if($available && $unavailable) {
                    array_push($additionalSql, ""); 
                }else {
                    !$available ?: array_push($additionalSql, "AND quantity>0"); 
                    !$unavailable ?: array_push($additionalSql, "AND quantity=0");
                }
            }
        }

        if(isset($_GET["filterCordWidth"])) {
            foreach ($widthArr as $key => $width) {
                array_push($additionalSql, "AND thicknesses = ?");
            }
        }

        if(isset($_GET["filterCordLength"])) {
            foreach ($handlerArr as $key => $handler) {
                array_push($additionalSql, "AND length = ?");
            }
        }
        
        $paramTypes = "ssd";
        $paramValues = [$category, $minPrice, $maxPrice]; 
        $sql = "SELECT * from $table WHERE category = ? AND price>= ? AND price<= ? ".implode(" ",$additionalSql);
        $stmt = $this->conn->prepare($sql);

        if($widthArr) {
            foreach ($widthArr as $width) {
                $paramTypes .= "s";
                array_push($paramValues, $width);
            }
        }
        if($lengthArr) {
            foreach ($lengthArr as $length) {
                $paramTypes .= "s";
                array_push($paramValues, $length);
            }
        }
        $stmt->bind_param($paramTypes, ...$paramValues);
        $stmt->execute();
        $results = $stmt->get_result();
        while($data = $results->fetch_assoc()) {
            $products[] = $data;
        }
        if(count($products)) {
            echo $this->cardPrint($products, $category);
        }else {
            echo "
            <div class='d-flex justify-content-center align-items-center flex-column'>
                <i class='text-danger fs-2 bi bi-ban'></i>
                <p class='text-danger fs-2'>Nismo pronašli ništa!</p>
            </div>
            ";
        }
    }
}