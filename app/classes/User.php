<?php 
require "./vendor/autoload.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class User {
    protected $conn;
    private $minValue = 0;
    private $maxValue = 1000;
    public $dotenv;
    public $pageNumber = 1;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
        $this->dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
        $this->dotenv->load();
    }

    public function getDataWithoutCondition($table) {
        $sql = "SELECT * FROM ".$table;
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $results = $stmt->get_result();

        $data = array();

        while($row = $results->fetch_assoc()) {
            $data[] =$row;
        }

        return $data;
    }

    
    public function checkout() {
        \Stripe\Stripe::setApiKey($_ENV["STRIPE_KEY"]);
        $checkout_session = \Stripe\Checkout\Session::create([
            "mode" => "payment",
            "success_url" => "http://localhost/yonex/successPage.php",
            "line_items" => $this->selectProductsFromCart()["cartArray"],
        ]);
        header("Location:" . $checkout_session->url);
    }

    public function selectProductsFromCart() {
        $data = $this->getCartData()[0];
        $cartArray = array();
        $orderData = ["id" => array(), "quantity" => array()];

        foreach ($data as $key => $product) {
            $productData = $this->getDataFromEachProduct($product["product_id"]);
            array_push($cartArray, [
                "quantity" => $product["quantity"],
                "price_data" => [
                    "currency" => "eur",
                    "unit_amount"=> $productData["price"]*100,
                    "product_data"=> [
                        "name"=>$productData["name"]
                    ]
                ]
            ]);

            array_push($orderData["id"],$product["product_id"]);
            array_push($orderData["quantity"],$product["quantity"]);
        }

        return ["cartArray"=>$cartArray,"orderData"=>$orderData];
    }

    public function submitCheckout() {
        $data = $this->getCartData()[1];
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            if(isset($_POST["submitCheckout"]) && $data >= 1) {
                header("Location: checkoutAddress.php");
                // $this->checkout();
            }
        }
    }

    public function submitAddressCheckout() {
        $_SESSION["addressData"] = [];
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            if(isset($_POST["submitAddressCheckout"])) {
                $addressData = [
                    "fullName"=> $fullName = isset($_POST["fullName"]) ? $_POST["fullName"] : NULL ,
                    "email"=> $fullName = isset($_POST["email"]) ? $_POST["email"] : NULL ,
                    "phoneNumber"=> $phoneNumber = isset($_POST["phoneNumber"]) ?  $_POST["phoneNumber"] : NULL,
                    "address" => $address = isset($_POST["address"]) ? $_POST["address"] : NULL,
                    "postcode" => $postcode = isset($_POST["postcode"]) ? $_POST["postcode"] : NULL,
                    "town" => $town = isset($_POST["town"]) ? $_POST["town"] : NULL,
                    "saveAddress" => $saveAddress =isset($_POST["saveAddress"]) ? $_POST["saveAddress"] : NULL];
                foreach ($addressData as $key => $data) {
                    if(!$data && $key !== "saveAddress") {
                        $_SESSION["message"]["type"] = "danger";
                        $_SESSION["message"]["text"] = "Molimo unesite sva polja";
                        return;
                    }
                }
                if($addressData["saveAddress"]) {
                    $user_id = $_SESSION["user_id"];
                    $sql = "UPDATE users SET address = ?, postcode = ?, town = ? WHERE user_id = ?";
                    $stmt = $this->conn->prepare($sql);
                    $stmt->bind_param("ssss", $addressData["address"], $addressData["postcode"], $addressData["town"], $user_id);
                    $stmt->execute();
                }
                $_SESSION["addressData"] = ["fullName" => $addressData["fullName"],"email" => $addressData["email"], "phoneNumber" => $addressData["phoneNumber"],
                "address" => $addressData["address"], "postcode" => $addressData["postcode"], "town" => $addressData["town"]];
                $this->checkout();
            }
        }
    }
    
    public function afterSuccessfulCheckout() {
        $productIDs = $this->selectProductsFromCart()["orderData"]["id"];
        $productQuantities = $this->selectProductsFromCart()["orderData"]["quantity"];
        $fullName = $_SESSION["addressData"]["fullName"];
        $email = $_SESSION["addressData"]["email"];
        $phoneNumber = $_SESSION["addressData"]["phoneNumber"];
        $address = $_SESSION["addressData"]["address"];
        $postcode = $_SESSION["addressData"]["postcode"];
        $town = $_SESSION["addressData"]["town"];
        $sql = "SELECT MAX(order_id) AS max_order_id FROM orders";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $orderID = $result->fetch_assoc()['max_order_id']+1;
        $isSent = 0;
        foreach($productIDs as $key => $productID) {
            $sql = "INSERT INTO orders (order_id, product_id, user_id,quantity,fullName,email,phoneNumber,address,postcode,city, isSent) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("sssssssssss", $orderID, $productID, $_SESSION["user_id"],$productQuantities[$key],$fullName,$email, $phoneNumber, $address, $postcode,$town, $isSent);
            $stmt->execute();
        }
        
        $sql = "DELETE FROM cart WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $_SESSION["user_id"]);
        $stmt->execute();  
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
        $sql = "SELECT user_id, password,name, is_admin FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $results = $stmt->get_result();

        if ($results->num_rows == 1) {
            $user = $results->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION["name"] = $user["name"];
                if($user["is_admin"] == "1") {
                    return "admin";
                }else {
                    return true;
                }
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
        $mail = new PHPMailer(true);
    
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->isSMTP();
        $mail->SMTPAuth = true;
    
        $mail->Host = $_ENV["MAIL_HOST"];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = $_ENV["MAIL_PORT"];
        $mail->Username=$_ENV["MAIL_USERNAME"];
        $mail->Password=$_ENV["MAIL_PASSWORD"];
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
        }
    }

    // provjera ulogiranosti
    public function is_logged() {
        if(isset($_SESSION['user_id'])) {
            return true;
        }
        return false;
    }

    public function is_admin($user_id) {
        if(!isset($_SESSION['user_id'])) return false;
        $sql = "SELECT is_admin FROM users WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $user_id);
        $stmt->execute();
        $reuslt = $stmt->get_result();
        while ($row = $reuslt->fetch_assoc()) {
            $data = $row;
            $is_admin = $data["is_admin"] == 1 ? true: false;
        }
        return $is_admin;
    }

    public function relocate() {
        $is_admin = $this->is_admin($_SESSION["user_id"]);
        $is_logged = $this->is_logged();
        if($is_admin && $is_logged) return false;
        header("Location: index.php");
        exit();
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

    public function truncString($string, $length = 100, $append="...") {
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

    public function getDataFromEachProduct($data_id) {
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
        return $data;
    }

    public function singleProduct() {
        $data_id = isset($_GET["data"]) ? $_GET["data"] : null;

        if($data_id) {
            $data = $this->getDataFromEachProduct($data_id);
            echo $this->productPrint($data);
        }
    }

    public function getInfo($table, $category) {
        $pageNum = isset($_GET["page"]) ? +$_GET["page"] : null;
        $sql = "SELECT * FROM $table WHERE category = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s",$category);
        $stmt->execute();
        $result = $stmt->get_result();
        $numProducts = $result->num_rows;
        $numPages = ceil($numProducts/$_ENV["PRODUCTS_PER_PAGE"]);
        return [
            "pageNum" => $pageNum,
            "numProducts" => $numProducts,
            "numPages" => $numPages
        ];
    }

    public function printPagesButtons($table, $category) {
        $pageNum = $this->getInfo($table, $category)["pageNum"];
        $numPages = $this->getInfo($table, $category)["numPages"];
        $numProducts = $this->getInfo($table, $category)["numProducts"];
        echo $this->pagesButtonsCode($pageNum, $numPages, $numProducts);
    }

    public function pagesButtonsCode($pageNum,$numPages,$numProducts) {
        $code = "";
        if($pageNum < 1) {$pageNum = 1;}
        if($numProducts >= $_ENV["PRODUCTS_PER_PAGE"]) {
            if($pageNum === 1) {
                $code.= "
                    <div class='container d-flex justify-content-end my-5'>
                        <button name='next__page' type='submit' class='btn btn-secondary'>Sljedeća ".($pageNum + 1)."</button>
                    </div>
                ";
            }else if ($pageNum == $numPages) {
                $code.= "
                    <div class='container d-flex justify-content-start my-5'>
                        <button name='previous__page' type='submit' class='btn btn-secondary'>Prethodna ".($pageNum - 1)."</button>
                    </div>
                ";
            }else {
                $code.= "
                    <div class='container d-flex justify-content-between my-5'>
                        <button name='previous__page' type='submit' class='btn btn-secondary'>Prethodna ".($pageNum - 1)."</button>
                        <button name='next__page' type='submit' class='btn btn-secondary'>Sljedeća ".($pageNum +1)."</button>
                    </div> 
                ";
            }
        }
        return $code;
    }

    public function previousAndNextPage() {
        $pageNum = isset($_GET["page"]) ? +$_GET["page"] : 1;
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if(isset($_POST["next__page"])) {
                $pageNum = $pageNum + 1;
            }if(isset($_POST["previous__page"])) {
                $pageNum = $pageNum - 1;
            }
            $_SESSION["pageNumber"] = $pageNum;
            $url = $this->newUrl($_SESSION["pageNumber"]);
            header("Location: $url");
            exit();
        }
    }

    public function newUrl($page=1) {
        $newURL = null;
        $currentUrl = $_SERVER['REQUEST_URI'];
        $urlParts = parse_url($currentUrl);

        $queryParams = array();
        if(isset($urlParts['query'])) {
            parse_str($urlParts['query'], $queryParams);
        }
        // unset($queryParams['page']);
        $queryParams['page'] = $page;
        $formattedQueryParams = array();
        foreach ($queryParams as $key => $value) {
            if(is_array($value)) {
                foreach ($value as $index => $subValue) {
                    $formattedQueryParams["{$key}[{$index}]"] = $subValue;
                }
            } else {
                $formattedQueryParams[$key] = $value;
            }
        }
        $newQueryString = http_build_query($queryParams);
        $baseURL = $urlParts['path'];
        $newURL .= $baseURL . '?' . $newQueryString;
        return $newURL;
    }

    public function getProductsRackets($category) {
        $sql = "SELECT * FROM rackets WHERE category=?";
        $stmt= $this->conn->prepare($sql);
        $stmt->bind_param("s",$category);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];
        while($row = $result->fetch_assoc()) {
            array_push($data,$row);
        }

        return $this->cardPrintIndex($data,$category);
    }


    //Code printing
    private function cardPrintIndex($array, $category) {
        $code = "";
        foreach($array as $key => $product) {
            if($key<=1) {
                if($product["category"] == $category || $category == "search") {
                    $id = strval($product["id"]);
                    $isAlreadyAdded = $this->isProductAlreadyAdded($id);
                    $code.= "
                    <div class='card shop__card product__card' style='width: 49%;'>
                        <form method='post'>
                            <a href='product.php?data=".$product['id']."'>  
                                <input type='hidden' name='product_id' value='".$product['id']."'>
                                <img src='".$product['img_url']."' class='card-img-top' alt='".$product['id']."'>
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
                                        <div class='btn btn-light d-flex gap-1 justify-content-center align-items-center'>
                                            <i class='bi bi-cart-fill'></i>
                                            <p class='lead m-0'>Dodaj u košaricu</p>
                                        </div>
                              ";
                }
                else if($product["quantity"]<= 0) {
                    $code.="
                                    <p class='fs-6 fw-semibold text-danger m-0 mb-3'>Nedostupno</p>
                                    <div class='btn-group' role='group' aria-label='Basic radio toggle button group'>
                                        <div class='btn btn-light d-flex gap-1 justify-content-center align-items-center disabled'>
                                            <i class='bi bi-cart-fill'></i>
                                            <p class='lead m-0'>Dodaj u košaricu</p>
                                        </div>
                    ";
                }
                if(!$isAlreadyAdded) {
                    $code.= "
                                        <button name='update_wishlist' type='submit' class='btn btn-light d-flex gap-1 justify-content-center align-items-center'>
                                            <i class='bi bi-heart'></i>
                                        </button>
                    ";
                }else  {
                    $code.= "
                                        <button name='update_wishlist' type='submit' class='btn btn-light d-flex gap-1 justify-content-center align-items-center bg-danger border-danger'>
                                            <i class='bi bi-heart-fill text-light'></i>
                                        </button>
                    ";
                }
                $code.= " 
                                    </div> 
                                </div>
                            </a>
                        </form>
                    </div> ";
                }
            }
        }
        return $code;
    }

    private function cardPrint($array, $category) {
        $code = "";
        $pageNum = isset($_GET["page"]) ? +$_GET["page"] : 1;
        $min = ($pageNum * $_ENV["PRODUCTS_PER_PAGE"]) - $_ENV["PRODUCTS_PER_PAGE"];
        $max = ($pageNum * $_ENV["PRODUCTS_PER_PAGE"]) -1;
        foreach($array as $key => $product) {
            if($key >= $min && $key<=$max) {
                if($product["category"] == $category || $category == "search") {
                    $id = strval($product["id"]);
                    $isAlreadyAdded = $this->isProductAlreadyAdded($id);
                    $code.= "
                    <div class='card shop__card product__card'>
                        <form method='post'>
                            <a href='product.php?data=".$product['id']."'>  
                                <input type='hidden' name='product_id' value='".$product['id']."'>
                                <img src='".$product['img_url']."' class='card-img-top' alt='".$product['id']."'>
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
                                        <div class='btn btn-light d-flex gap-1 justify-content-center align-items-center'>
                                            <i class='bi bi-cart-fill'></i>
                                            <p class='lead m-0'>Dodaj u košaricu</p>
                                        </div>
                              ";
                }
                else if($product["quantity"]<= 0) {
                    $code.="
                                    <p class='fs-6 fw-semibold text-danger m-0 mb-3'>Nedostupno</p>
                                    <div class='btn-group' role='group' aria-label='Basic radio toggle button group'>
                                        <div class='btn btn-light d-flex gap-1 justify-content-center align-items-center disabled'>
                                            <i class='bi bi-cart-fill'></i>
                                            <p class='lead m-0'>Dodaj u košaricu</p>
                                        </div>
                    ";
                }
                if(!$isAlreadyAdded) {
                    $code.= "
                                        <button name='update_wishlist' type='submit' class='btn btn-light d-flex gap-1 justify-content-center align-items-center'>
                                            <i class='bi bi-heart'></i>
                                        </button>
                    ";
                }else  {
                    $code.= "
                                        <button name='update_wishlist' type='submit' class='btn btn-light d-flex gap-1 justify-content-center align-items-center bg-danger border-danger'>
                                            <i class='bi bi-heart-fill text-light'></i>
                                        </button>
                    ";
                }
                $code.= " 
                                    </div> 
                                </div>
                            </a>
                        </form>
                    </div> ";
                }
            }
        }
        return $code;
    }

    private function productPrint($data) {
        $isAddedToWishlist = $this->isProductAlreadyAdded($data["id"]);
        $code="";
        $code.= "
            <form method='post' class='my-5'>
                <input type='hidden' name='product_id' value='".htmlspecialchars($data['id'], ENT_QUOTES, 'UTF-8')."'>
                <div class='row mt-3 mb-5 justify-content-md-start justify-content-center'>
                    <div class='col-md-6 col-12 mb-3 mb-md-0'>
                        <div class='me-5 shadow shadow-sm border border-1 rounded d-flex justify-content-center align-items-center'>
                            <img src='".htmlspecialchars($data['img_url'], ENT_QUOTES, 'UTF-8')."'  class='img-fluid my-5' alt='".htmlspecialchars($data['description'], ENT_QUOTES, 'UTF-8')."'>
                        </div>
                    </div>
                    <div class='col-md-6 col-12'>
            ";
        if(!$isAddedToWishlist) {
            $code.="        
                    <button name='update_wishlist' type='submit' class='btn btn-light border border-2'><i class='bi bi-heart'></i></button>";
        }else {
            $code.="        
                    <button name='update_wishlist' type='submit' class='btn btn-light border border-2 border-danger bg-danger'><i class='bi bi-heart-fill text-light'></i></button>";

        }
        $code.="
                        <h2 class='my-3'>".htmlspecialchars($data['name'], ENT_QUOTES, 'UTF-8')."</h2>
                        <p class='mb-1'>Proizvođač: <span class='text-black fw-bold'>Yonex</span></p>
                        <p class='mb-1'>Šifra: <span class='text-black fw-bold'>".htmlspecialchars($data['id'], ENT_QUOTES, 'UTF-8')."</span></p>";
        if($data["quantity"]>0) {
            $code.="
                        <p class='mb-1'>Dostupnost: <span class='text-success fw-bold'>Dostupno</span></p>
            ";
        }else {
            $code.="
                        <p class='mb-1'>Dostupnost: <span class='text-danger fw-bold'>Nedostupno</span></p>
            ";
        }
        $code.="
                        <h2><span>".htmlspecialchars($data['price'], ENT_QUOTES, 'UTF-8')."</span> €</h2>
                        <p class='fw-semibold text-secondary'>Bez PDV-a <span>".htmlspecialchars($data['priceNOTAX'], ENT_QUOTES, 'UTF-8')."</span> €</p>
                        <hr>
                        <h4>Dostupne mogućnosti</h4>
                        <p class='fw-semibold'>Količina</p>
                        <input type='number' name='product_quantity' class='form-control' min='0' max='".htmlspecialchars($data['quantity'], ENT_QUOTES, 'UTF-8')."' value='1'>";
        if($data["quantity"]>0) {
            $code.="
                        <button type='submit' name='add_to_cart' class='btn btn-dark d-flex gap-3 mt-3'>
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
                    <p>".htmlspecialchars($data['description'], ENT_QUOTES, 'UTF-8')."</p>
                </div>
            </form>";

        return $code;
    }

    private function printWishlistCard($data) {
        $data = $data["data"];
        $code = "";
        $code.= "
            <div class='card mb-3 card__products'>
                <form method='post'>
                    <input type='hidden' name='product_id' value='".$data['id']."'>
                    <a href='product.php?data=".$data['id']."'>
                        <div class='row g-0'>
                            <div class='col-md-4 d-flex justify-content-center'>
                                <img src='".$data['img_url']."' class='img-fluid rounded-start' alt='".$data['description']."'>
                            </div>
                            <div class='col-md-8'>
                                <div class='card-body'>
                                    <div class='row'>
                                        <div class='col-6'>
                                        <h5 class='card-title fs-3 fw-bold'>".$data['name']."</h5>
                                        </div>
                                        <div class='col-6 pe-5 d-flex justify-content-end align-items-sm-start align-items-center bg-transparent'>
                                            <button name='update_wishlist' type='submit' class='bg-transparent border border-0'>
                                                <i class='fs-5 text-danger bi bi-trash-fill'></i>
                                            </button>
                                        </div>
                                    </div>
                                    <p class='card-text'>".$data['description']."</p>
                                    <div class='row'>
                                        <div class='col-6 d-flex align-items-center gap-3'>
                                            <p class='fs-3 fw-semibold m-0'><span>".$data['price']."</span>€</p>
                                            <p class='fs-5 m-0'><span>".$data['priceNOTAX']."</span>€</p>
                                        </div>
        ";
        if($data["quantity"] > 0) {
            $code.= "
                                        <div class='col-6 d-flex justify-content-end'>
                                            <button type='submit' name='add_to_cart' class='btn btn-lg btn-dark'>Dodaj u kosaricu</button>
                                        </div>
                                    </div>
                                    <div class='d-flex justify-content-start'>
                                        <p class='fs-6 fw-semibold text-success m-0'>Dostupno</p>
            ";
        }else {
            $code.= "
                                        <div class='col-6 d-flex justify-content-end'>
                                            <button class='btn btn-lg btn-dark' disabled>Dodaj u kosaricu</button>
                                        </div>
                                    </div>
                                    <div class='d-flex justify-content-start'>
                                        <p class='fs-6 fw-semibold text-danger m-0'>Nedostupno</p>
            ";
        }
            $code.="
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </form>
            </div>
            ";

        echo $code;
    }

    private function printCartCard($data,$quantity) {
        $code = "";
        $code = "
            <div class='row card__products border border-1 rounded shadow-sm mb-5'>
                <input type='hidden' name='product_id' value='".$data["id"]."' />
                <div class='col-12 col-lg-3 d-flex justify-content-center'>
                        <img class='img-thumbnail border-0' src='".$data['img_url']."' alt='".$data['description']."'>
                </div>
                <div class='col-12 col-lg-4 my-5 ps-xl-0 ps-3'>
                    <h1 class='fs-4 fw-bold'>".$data["name"]."</h1>
                    <p class='fs-6 fw-semibold text-success m-0'>Dostupno</p>
                </div>
                <div class='col-12 col-lg-3 d-flex align-items-center justify-content-center gap-5'>
                    <button name='increaseQuantity' class='change__quantity-btn btn btn-lightgrey fs-5 fw-bold'>+</button>
                    <input name='quantity' class='mb-0 text-center border border-0 quantity__product' min='1' max='".$data["quantity"]."' value='".$quantity."'>
                    <button name='decreaseQuantity' class='change__quantity-btn btn btn-lightgrey fs-5 px-3 fw-bold'>-</button>
                </div>
                <div class='col-12 col-lg-2 mt-5 d-flex flex-column align-items-lg-end align-items-start'>
                    <p class=' fs-3 fw-semibold m-0'><span class='real__price'>".$data["price"]."</span>€</p>
                    <p class='fs-5 m-0'><span>".$data["priceNOTAX"]."</span>€</p>
                    <button name='remove_from_cart' class='btn btn-transparent text-danger text-decoration-underline px-0'>Izbriši</button>
                </div>
            </div>
        ";

        echo $code;
    }

    public function getData($table) {
        $sql = "SELECT * from $table where user_id =?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s",$_SESSION['user_id']);
        $stmt->execute();
        $results = $stmt->get_result();
        $data = array();
        while ($row = $results->fetch_assoc())  {
            $data[] = $row;
        }
        return [$data,$results->num_rows];
    }

    public function isProductAlreadyAdded($id,$table="wishlist") {
        $sql = "SELECT * FROM $table WHERE product_id = ? and user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('ss', $id, $_SESSION["user_id"]);
        $stmt->execute();
        $results = $stmt->get_result();
        if($results->num_rows > 0){ return true; } else return false;
    }

    public function getProductsById($results) {
        $resultArr = $results;
        $idArr = array();
        $products = array();
        foreach ($resultArr as $key => $result) {
            if(isset($result["quantity"])) {
                array_push($idArr,["id"=>$result["product_id"],"quantity"=>$result["quantity"]]);
            }else {
                array_push($idArr,["id"=>$result["product_id"]]);
            }
        }
        foreach ($idArr as $key => $id) {
            $data = $this->getDataFromEachProduct($id["id"]);
            if(isset($result["quantity"])) {
                array_push($products,["data"=>$data,"quantity"=>$id["quantity"]]);
            }else {
                array_push($products,["data"=>$data]);
            }
        }
        return $products;
    }

    //Cart
    public function getCartData() { return $this->getData("cart");}

    public function displayProductsInCart() {
        $code="";
        $products = $this->getProductsById($this->getCartData()[0]);
        foreach ($products as $key => $data) {
            $code.= $this->printCartCard($data["data"],$data["quantity"]);
        }

        return $code;
    }

    public function changeChangeQuantity() {
        $productNumber = $this->getCartData()[1];
        if($_SERVER["REQUEST_METHOD"] == "POST" && $productNumber >= 1) {
            $quantity = +$_POST["quantity"];
            $product_id = $_POST["product_id"];
            $data = $this->getDataFromEachProduct($product_id);
            if(isset($_POST["increaseQuantity"])) {
                $quantity = $quantity+1;
                if($quantity > $data["quantity"])
                {
                    $quantity = $data["quantity"];
                }
            }else if(isset($_POST["decreaseQuantity"])) {
                $quantity = $quantity-1;
                if($quantity < 1)
                {
                    $quantity = 1;
                }
            }
            if($quantity > $data["quantity"])
            {
                $quantity = $data["quantity"];
            }
            $sql = "UPDATE cart SET quantity=? WHERE product_id=?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ss",$quantity,$product_id);
            $stmt->execute();
        }
    }

    public function findSetQuantityInCart($product_id) {
        $sql = "SELECT quantity FROM cart WHERE product_id=? AND user_id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss",$product_id,$_SESSION["user_id"]);
        $stmt->execute();
        $results = $stmt->get_result();
        $data = $results->fetch_assoc();
        return $data;
    }

    public function updateCart() {
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $product_id = isset($_POST["product_id"]) ? $_POST["product_id"] : NULL;
            $availableQuantity = isset($product_id) ? $this->getDataFromEachProduct($product_id)["quantity"] : NULL;
            if($_SESSION["user_id"]) {
                if(isset($_POST["add_to_cart"])) {
                    $quantity = isset($_POST["product_quantity"]) ? $_POST["product_quantity"] : 1;
                    if(isset($quantity) && isset($product_id)) {
                        if(!$this->isProductAlreadyAdded($product_id,"cart")) {
                            var_dump($availableQuantity);
                            var_dump($quantity);
                            if($quantity <= $availableQuantity) {
                                $sql = "INSERT INTO cart (product_id,user_id,quantity) VALUES(?, ?, ?)";
                                $stmt = $this->conn->prepare($sql);
                                $stmt->bind_param("sss",$product_id,$_SESSION["user_id"],$quantity);
                                $stmt->execute();
                                header("Location: cart.php");
                                exit();
                            }
                        }
                        else {
                            $quantity = +$quantity;
                            $quantityInCart = $this->findSetQuantityInCart($product_id)["quantity"];
                            $newQuantity = $quantityInCart + $quantity;
                            $availableAmount = $availableQuantity - $quantityInCart;
                            if($newQuantity <= $availableQuantity) {
                                $sql = "UPDATE cart SET quantity = ? WHERE product_id = ? AND user_id = ?";
                                $stmt = $this->conn->prepare($sql);
                                $stmt->bind_param("sss",$newQuantity,$product_id,$_SESSION["user_id"]);
                                $stmt->execute();
                                header("Location: cart.php");
                                exit();
                            }else {
                                $_SESSION["message"]["type"] = "danger";
                                $_SESSION["message"]["text"] = "Nažalost unijeli ste količinu veće od dostupne, probajte sa količinom do $availableAmount";
                            }
                        }
        
                    }
                }if(isset($_POST["remove_from_cart"])) {
                    $sql = "DELETE FROM cart WHERE product_id = ? AND user_id =?";
                    $stmt = $this->conn->prepare($sql);
                    $stmt->bind_param("ss",$product_id,$_SESSION["user_id"]);
                    $stmt->execute();
                }if(isset($_POST["remove_all_cart"])) {
                    $sql = "DELETE FROM cart WHERE user_id =?";
                    $stmt = $this->conn->prepare($sql);
                    $stmt->bind_param("s",$_SESSION["user_id"]);
                    $stmt->execute();
                }
            }else {
                header("Location: login.php");
                exit();
            }
        }
    }

    //Wishlist
    public function updateWishlist() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if(isset($_POST["product_id"]) && isset($_POST["update_wishlist"])) {
                if($_SESSION["user_id"]) {
                    if($this->isProductAlreadyAdded($_POST["product_id"],"wishlist")) {
                        $sql = "DELETE FROM wishlist WHERE product_id = ? and user_id = ?";
                    }else {
                        $sql = "INSERT INTO wishlist (product_id, user_id) VALUES (?,?)";
                    }
                    $stmt = $this->conn->prepare($sql);
                    $stmt->bind_param('ss',$_POST["product_id"],$_SESSION["user_id"]);
                    $stmt->execute();
                }else {
                    header("Location: login.php");
                    exit();
                }
            }
        }
    }

    public function getWishlistData() {return $this->getData("wishlist");}

    public function displayProductsInWishlist() {
        $code="";
        $products = $this->getProductsById($this->getWishlistData()[0]);
        foreach ($products as $key => $data) {
            $code.= $this->printWishlistCard($data);
        }

        echo $code;
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

    private function getDataWithOneCondition( $filterName, $condition =  "everything") {
        $sql = "SELECT * FROM `checkboxfilters` WHERE category = ? AND filterName = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss",$condition, $filterName);
        $stmt->execute();
        $results = $stmt->get_result();
        return $results;
    }
    
    public function availabilityFilter() {
        $sql = "SELECT * FROM `checkboxfilters` WHERE category = 'everything' AND filterName = 'availability'";
        $stmt = $this->conn->prepare($sql);
        // $stmt->bind_param("ss","everything", "availability");
        $stmt->execute();
        $results = $stmt->get_result();
        $this->checkboxFilterPrint($results,"filterAvailability");
    }

    public function racketWeight($sport) {
        $results = $this->getDataWithOneCondition("racket_weight", $sport);
        $this->checkboxFilterPrint($results,"filterRacketWeight");
    }

    public function racketType($sport) {
        $results = $this->getDataWithOneCondition("racket_type", $sport);
        $this->checkboxFilterPrint($results,"filterRacketType");
    }

    public function handleType($sport) {
        $results = $this->getDataWithOneCondition("handle_type", $sport);
        $this->checkboxFilterPrint($results,"filterHandleType");
    }

    public function shoesSize() {
        $results = $this->getDataWithOneCondition($filterName ="shoes_size");
        $this->checkboxFilterPrint($results,"filterShoesSize");
    }

    public function genderFilter() {
        $results = $this->getDataWithOneCondition("gender");
        $this->checkboxFilterPrint($results,"filterGender");
    }

    public function cordWidth($sport) {
        $results = $this->getDataWithOneCondition("cord_width", $sport);
        $this->checkboxFilterPrint($results,"filterCordWidth");
    }

    public function cordLength($sport) {
        $results = $this->getDataWithOneCondition("cord_length", $sport);
        $this->checkboxFilterPrint($results,"filterCordLength");
    }

    public function ballType($sport) {
        $results = $this->getDataWithOneCondition("ball_type", $sport);
        $this->checkboxFilterPrint($results,"filterBallType");
    }

    public function ballSpeed($sport) {
        $results = $this->getDataWithOneCondition("ball_speed", $sport);
        $this->checkboxFilterPrint($results,"filterBallSpeed");
    }

    public function bagType($sport) {
        $results = $this->getDataWithOneCondition("bag_type", $sport);
        $this->checkboxFilterPrint($results,"filteBagType");
    }

    public function bagSize($sport) {
        $results = $this->getDataWithOneCondition("bag_size", $sport);
        $this->checkboxFilterPrint($results,"filteBagSize");
    }

    public function clothingSize($sport) {
        $results = $this->getDataWithOneCondition("clothing_size", $sport);
        $this->checkboxFilterPrint($results,"filteClothingSize");
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
                array_push($additionalSql, "AND racketWeight = ?");
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
            echo "<div id='productContainer' class='row mt-3 ps-3 gap-2 justify-content-sm-start justify-content-center'>";
            echo $this->cardPrint($products, $category);
            echo "</div>";
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
            foreach ($genderArr as $key => $gender) {
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
            foreach ($lengthArr as $key => $handler) {
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

    public function printBallsFilters($table, $category) {
        $products = [];
        $additionalSql = [];
        $available = false;
        $unavailable = false;
        $minPrice = isset($_GET["filterPrice"][0]) ? +$_GET["filterPrice"][0] : $this->minValue;
        $maxPrice = isset($_GET["filterPrice"][1]) ? +$_GET["filterPrice"][1] : $this->maxValue;
        $ballTypeArr = isset($_GET["filterBallType"]) ? $_GET["filterBallType"] : null;
        $ballSpeedArr = isset($_GET["filterBallSpeed"]) ? $_GET["filterBallSpeed"] : null;
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

        if(isset($_GET["filterBallType"])) {
            foreach ($ballTypeArr as $key => $type) {
                array_push($additionalSql, "AND type = ?");
            }
        }

        if(isset($_GET["filterBallSpeed"])) {
            foreach ($ballSpeedArr as $key => $speed) {
                array_push($additionalSql, "AND speed = ?");
            }
        }
        
        $paramTypes = "ssd";
        $paramValues = [$category, $minPrice, $maxPrice]; 
        $sql = "SELECT * from $table WHERE category = ? AND price>= ? AND price<= ? ".implode(" ",$additionalSql);
        $stmt = $this->conn->prepare($sql);

        if($ballTypeArr) {
            foreach ($ballTypeArr as $type) {
                $paramTypes .= "s";
                array_push($paramValues, $type);
            }
        }

        if($ballSpeedArr) {
            foreach ($ballSpeedArr as $speed) {
                $paramTypes .= "s";
                array_push($paramValues, $speed);
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

    public function printBagsFilters($table, $category) {
        $products = [];
        $additionalSql = [];
        $available = false;
        $unavailable = false;
        $minPrice = isset($_GET["filterPrice"][0]) ? +$_GET["filterPrice"][0] : $this->minValue;
        $maxPrice = isset($_GET["filterPrice"][1]) ? +$_GET["filterPrice"][1] : $this->maxValue;
        $bagTypeArr = isset($_GET["filteBagType"]) ? $_GET["filteBagType"] : null;
        $begSizeArr = isset($_GET["filteBagSize"]) ? $_GET["filteBagSize"] : null;
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

        if(isset($_GET["filteBagType"])) {
            foreach ($bagTypeArr as $key => $type) {
                array_push($additionalSql, "AND type = ?");
            }
        }

        if(isset($_GET["filteBagSize"])) {
            foreach ($begSizeArr as $key => $size) {
                array_push($additionalSql, "AND size = ?");
            }
        }
        
        $paramTypes = "ssd";
        $paramValues = [$category, $minPrice, $maxPrice]; 
        $sql = "SELECT * from $table WHERE category = ? AND price>= ? AND price<= ? ".implode(" ",$additionalSql);
        $stmt = $this->conn->prepare($sql);

        if($bagTypeArr) {
            foreach ($bagTypeArr as $type) {
                $paramTypes .= "s";
                array_push($paramValues, $type);
            }
        }

        if($begSizeArr) {
            foreach ($begSizeArr as $size) {
                $paramTypes .= "s";
                array_push($paramValues, $size);
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

    public function printClothingFilters($table, $category) {
        $products = [];
        $additionalSql = [];
        $available = false;
        $unavailable = false;
        $minPrice = isset($_GET["filterPrice"][0]) ? +$_GET["filterPrice"][0] : $this->minValue;
        $maxPrice = isset($_GET["filterPrice"][1]) ? +$_GET["filterPrice"][1] : $this->maxValue;
        $sizeArr = isset($_GET["filteClothingSize"]) ? $_GET["filteClothingSize"] : null;
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

        if(isset($_GET["filteClothingSize"])) {
            foreach ($sizeArr as $key => $size) {
                array_push($additionalSql, "AND size = ?");
            }
        }

        if(isset($_GET["filterGender"])) {
            foreach ($genderArr as $key => $gender) {
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

    public function printUsersOrders($userId) {
        $sql = "SELECT * FROM orders WHERE user_id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s",$userId);
        $stmt->execute();
        $results = $stmt->get_result();

        if($results->num_rows < 1) {
            echo "<p class='d-flex justify-content-center align-items-center'>Trenutno nemate niti jednu narudžbu</p>";
            return;
        }

        $data= array();
        while($row= $results->fetch_assoc()) {
            $productData = $this->getDataFromEachProduct($row["product_id"]);
            $orderId = $row['order_id'];
            if(!isset($data[$orderId])) {
                $data[$orderId] = ["product_id" => [],"names" => [], "quantity" => []];
            }
            $data[$orderId]["names"][] = $productData["name"];
            $data[$orderId]["product_id"][] = $row["product_id"];
            $data[$orderId]["quantity"][] = $row["quantity"];
        }
        
        $orderNum = 1;
        foreach ($data as $orderId => $order) {
            $productDetails = [];
            $totalPrice = 0;
            foreach ($order["names"] as $index => $name) {
                $productData = $this->getDataFromEachProduct($order["product_id"][$index]);
                $quantity = $order["quantity"][$index];
                $productDetails[] = $name. " (" . $quantity . ")";
                $totalPrice += (+$quantity* $productData["price"]);
            }
            echo "
             <a href='#' class='card w-100 mb-3 my-3 shadow-sm'>
                <div class='card-body d-flex justify-content-between'>
                    <div>
                        <h5 class='card-title'>Narudžba ".$orderNum."</h5>
                        <p class='card-text'>".$this->truncString(implode(", ",$productDetails),50)."</p>
                    </div>
                    <div>
                        <h4>Ukupna cijena: $totalPrice €</h4>
                    </div>
                </div>
            </a>
            ";
            $orderNum++;
        }
    }

    public function printAllOrders() {
        $sql = "SELECT * FROM orders ORDER BY id DESC ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $results = $stmt->get_result();

        if($results->num_rows < 1) {
            echo "<p class='d-flex justify-content-center align-items-center'>Trenutno nemate niti jednu narudžbu</p>";
            return;
        }

        $data = array();
        while($row = $results->fetch_assoc()) {
            $productData = $this->getDataFromEachProduct($row["product_id"]);
            $orderId = $row['order_id'];
            if(!isset($data[$orderId])) {
                $data[$orderId] = ["order_id" => 0,"product_id"=> [], "names" => [], "quantity" => [],"fullName" => [], "email" => [], "phoneNumber" => [], "address" => [], "postcode" => [], "city" => [], "isSent"=> 0];
            }

            $data[$orderId]["order_id"] = $row["order_id"];
            $data[$orderId]["product_id"][] = $row["product_id"];
            $data[$orderId]["names"][] = $productData["name"];
            $data[$orderId]["quantity"][] = $row["quantity"];
            $data[$orderId]["fullName"] = $row["fullName"];	
            $data[$orderId]["email"] = $row["email"];	
            $data[$orderId]["phoneNumber"] = $row["phoneNumber"];	
            $data[$orderId]["address"] = $row["address"];	
            $data[$orderId]["postcode"] = $row["postcode"];	
            $data[$orderId]["city"] = $row["city"];	
            $data[$orderId]["isSent"] = $row["isSent"];	
        }

        
        
        $orderNum = count($data);

        foreach($data as $orderId => $order) {
            $productDetails = ["description" => [], "id" => []];
            $totalPrice = 0;
            foreach ($order["names"] as $index => $name) {
                $productData = $this->getDataFromEachProduct($order["product_id"][$index]);
                $quantity = $order["quantity"][$index];
                array_push($productDetails["description"],$name. " (" . $quantity . ")");
                $productDetails["id"] = $productData["id"]; 
                $totalPrice += (+$quantity* $productData["price"]);
            }
            if(!$order["isSent"]) {
                echo "
                <a href='singleOrder.php?id=".$order["order_id"]."&orderNum=".$orderNum."'>
                    <div class='alert alert-danger d-flex justify-content-between' role='alert'>
                        <div>
                            <h5>Narudžba ".$orderNum."</h5>
                            <p >".$this->truncString(implode(", ",$productDetails["description"]),50)."</p>
                        </div>
                        <div>
                            <h4>Ukupna cijena: ".$totalPrice." €</h4>
                            <p><b>Korisnik</b>: ".$order["fullName"]."</p>
                        </div>
                    </div>
                </a>
                ";
            }else {
                echo "
                <a href='singleOrder.php?id=".$order["order_id"]."&orderNum=".$orderNum."'>
                    <div class='alert alert-success d-flex justify-content-between' role='alert'>
                        <div>
                            <h5 >Narudžba ".$orderNum."</h5>
                            <p >".$this->truncString(implode(", ",$productDetails["description"]),50)."</p>
                        </div>
                        <div>
                            <h4>Ukupna cijena: ".$totalPrice." €</h4>
                            <p><b>Korisnik</b>: ".$order["fullName"]."</p>
                        </div>
                    </div>
                </a>
                ";
            }

            $orderNum--;
        }
    }

    public function getDataAboutOrder($targetId) {
        $sql = "SELECT * FROM orders WHERE order_id = ".$targetId;
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $results = $stmt->get_result();

        $arrayWithAllOrders = array();

        while($row = $results->fetch_assoc()) {
            $arrayWithAllOrders[] =$row;
        }

        $myOrderArray = ["id" => null , "order_id" => null, "user_id" => null , "product_id" => [],"quantity" => [], "fullName" => null ,
        "email" => null, "phoneNumber" => null,  "address" => null, "postcode" => null , "city" => null , "isSent" =>null];

        
        foreach ($arrayWithAllOrders as $key => $order) {
            foreach ($order as $key => $field) {
                if($key === "product_id" || $key === "quantity") {
                    array_push($myOrderArray[$key], $field);
                }else {
                    $myOrderArray[$key] = $field;
                }
            }
        }
        return $myOrderArray;
    }

    public function printOrderProductCards($targetId) {
        $products = $this->getDataAboutOrder($targetId)["product_id"];
        $quantities = $this->getDataAboutOrder($targetId)["quantity"];

        foreach ($products as $key => $product_id) {
            $productData = $this->getDataFromEachProduct($product_id);
            // var_dump($productData);
            echo "
                <form method='post'>
                    <div class='card' style='width: 18rem;'>
                        <div class='imgSingleOrder'> 
                            <img src='".$productData["img_url"]."' class='card-img-top'>
                        </div>

                        <div class='card-body align-items-end'>
                            <input type='hidden' name='productId' value='".$product_id."'>
                            <h5 class='card-title'>".$productData["name"]."</h5>
                            <p class='card-text'>".$this->truncString($productData["description"],200)."</p>
                            <div class='d-flex justify-content-between'>
                                <div>
                                    <h4 class='card-text'>Cijena: ".$productData["price"]."€</h4>
                                    <p class='card-title'>Količina (".$quantities[$key].")</p>
                                </div>
                                <button type='submit' name='deleteProduct' class='align-self-end border border-0 rounded-3 px-3 py-2 bg-danger text-light'><i class='bi bi-trash'></i></button>
                            </div>
                        </div>
                    </div>
                </form>
            ";
            // var_dump($product_id);
        }
    }

    public function deleteProductFromOrder($orderId) {
        if($_SERVER["REQUEST_METHOD"]== "POST") {
            if(isset($_POST["deleteProduct"])) {
                $sql = "DELETE FROM orders WHERE product_id = ? AND order_id = ?";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("ss", $_POST["productId"], $orderId);
                $stmt->execute();
            }
        }
    }

    public function printAllProductsFromCart() {
        $is_sent = 0 || 1;
        $sql = "SELECT* FROM orders WHERE isSent = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $is_sent);
        $stmt->execute();
        $results = $stmt->get_result();
        $order_ids = array();
        
        if($results->num_rows > 0) {
           while($row = $results->fetch_assoc()) {
                $sql = "SELECT count(*) FROM orders WHERE order_id =?";
                $stmt= $this->conn->prepare($sql);
                $stmt->bind_param("s",$row["order_id"]);
                $stmt->execute();   
                $counterResult = $stmt->get_result();
                $count = $counterResult->fetch_array()[0];

                if($count === 1) {
                    echo "
                        <tr>
                            <td>".$row["order_id"]."</td>
                            <td>".$row["product_id"]."</td>
                            <td>".$row["quantity"]."</td>
                            <td>".$row["fullName"]."</td>
                            <td>".$row["email"]."</td>
                            <td>".$row["phoneNumber"]."</td>
                            <td>".$row["address"]."</td>
                            <td>".$row["postcode"]."</td>
                            <td>".$row["city"]."</td>
                            <td class='bg-danger'>".$row["isSent"]."</td>
                        </tr>
                    ";
                    array_push($order_ids,$row["order_id"]);
                }else if($count !== 1 && !in_array($row["order_id"],$order_ids)) {
                    echo "
                        <tr>
                            <td rowspan=".$count.">".$row["order_id"]."</td>
                            <td >".$row["product_id"]."</td>
                            <td >".$row["quantity"]."</td>
                            <td rowspan=".$count.">".$row["fullName"]."</td>
                            <td rowspan=".$count.">".$row["email"]."</td>
                            <td rowspan=".$count.">".$row["phoneNumber"]."</td>
                            <td rowspan=".$count.">".$row["address"]."</td>
                            <td rowspan=".$count.">".$row["postcode"]."</td>
                            <td rowspan=".$count.">".$row["city"]."</td>
                            <td rowspan=".$count." class='bg-danger'>".$row["isSent"]."</td>
                        </tr>
                    ";
                    array_push($order_ids,$row["order_id"]);
                }else {
                    echo "
                        <tr>
                            <td >".$row["product_id"]."</td>
                            <td >".$row["quantity"]."</td>
                        </tr>
                    ";
                }
           }

        }
    }

    public function exportToExcel() {
        if($_SERVER["REQUEST_METHOD"]=="POST") {
            if(isset($_POST["exportExcel"])) {
                header("Content-Type: application/vnd.ms-excel");
                header("Content-Disposition: attachment; filename=orders.xls");

                $sql = "UPDATE orders SET isSent = 1 WHERE isSent = 0";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
            }
        }
    }
}