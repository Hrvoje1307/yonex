<?php
  require "./vendor/autoload.php";

  $user = new User();


  class Model {
    protected $conn;
    public $dotenv;
    protected $user;


    public function __construct(User $user) {
      global $conn;
      $this->conn = $conn;
      $this->dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
      $this->dotenv->load();
      $this->user = $user;
    }

    public function getProducts() {
      $json = file_get_contents("./app/config/products.json");
      $obj = json_decode($json, true);
      $data = $obj["podjetje"]["izdelki"]["izdelek"];
      $products = array();
      foreach ($data as $key => $product) {
        array_push($products, [
          "position" => $key, 
          "id" => $product["izdelekID"],
          "name" => $product["izdelekIme"],
          "img" => isset($product["slikaMala"]) ? $product["slikaMala"] : null,
          "price" => $product["PPC"],
          "priceNOTAX" => $product["nabavnaCena"],
          "description" => $product["opis"],
          "category" => $product["kategorija"]["__cdata"],
        ]);
      } 

      return $products;
    }

    public function getInfoProducts() {
      $pageNum = isset($_GET['page']) ? (int)$_GET['page'] : 1;
      $productsNum = count($this->getProducts());
      $numPages = ceil($productsNum/$_ENV["PRODUCTS_PER_PAGE"]);

      return [
        "productsNum" => $productsNum,
        "numPages" => $numPages,
        "pageNum" => $pageNum,
      ];
    }

    public function printPagesButtons() {
      $pageNum = $this->getInfoProducts()["pageNum"];
      $productsNum = $this->getInfoProducts()["productsNum"];
      $numPages = $this->getInfoProducts()["numPages"];
      echo $this->user->pagesButtonsCode($pageNum,$numPages,$productsNum);
    }

    public function changePageNumber() {
      if($_SERVER["REQUEST_METHOD"] == "POST") {
        $pageNum = $this->getInfoProducts()["pageNum"];
        if(isset($_POST["next__page"])) {
          $pageNum++;
        }else if(isset($_POST["previous__page"])) {
          $pageNum--;
        }
        header("Location: dataDisplay.php?page=".$pageNum);
        exit();
      }
    }

    public function printProducts() {
      $pageNum = $this->getInfoProducts()["pageNum"];
      $min = ($pageNum * $_ENV["PRODUCTS_PER_PAGE"]) - $_ENV["PRODUCTS_PER_PAGE"];
      $max = ($pageNum * $_ENV["PRODUCTS_PER_PAGE"]) -1;
      $products = $this->getProducts();
      foreach ($products as $key => $product) {
        if($key >= $min && $key <= $max) {
          echo "
            <tr>
              <td>".$product['position']."</td>
              <td>".$product['id']."</td>
              <td>".$product['name']."</td>
              <td><img src=".$product["img"]."></td>
              <td>".$product['price']." €</td>
              <td>".$product['priceNOTAX']." €</td>
              <td>".$this->user->truncString($product["description"])."</td>
              <td>".$product['category']."</td>
            </tr>
          ";
        }
      }
    }

    public function getUsers() {
      $sql = "SELECT * FROM users";
      $stmt = $this->conn->prepare($sql);
      $stmt->execute();
      $results = $stmt->get_result();

      $data = array();

      while ($row = $results->fetch_assoc()) {
        array_push($data, $row);
      }

      return $data;
    }

    public function printUsers() {
      $users = $this->getUsers();

      foreach ($users as $key => $user) {
        $row = "";
        $row.= "
          <tr onclick =\"window.location.href='singleUser.php?data=".$user['user_id']."'\">
              <td>".$user['user_id']."</td>
              <td>".$user['name']."</td>
              <td>".$user['surname']."</td>
              <td>".$user['email']."</td>
              <td>".$user['number']."</td>";
        if($user["is_admin"] == 1) {
            $row.= "
              <td>admin</td>
            ";
        }else {
          $row.= "
              <td>kosrinik</td>
          ";
        }
        $row.= "
          </tr>
        ";
        echo $row;
      }
    }

    public function changeUserSettings() {
      $counter = 0;
      if($_SERVER["REQUEST_METHOD"] == "POST") {
        if(isset($_POST["submit"])) {
          $name = ["value" => $_POST["name"], "name" => "name"];
          $surname = ["value" => $_POST["surname"], "name" => "surname"];
          $email = ["value" => $_POST["email"], "name" => "email"];
          $number = ["value" => $_POST["number"], "name" => "number"];
          $admin = $_POST["userType"] == "1" ? ["value" => "1", "name" => "is_admin"] : ["value" => "0", "name" => "is_admin"];
          $toChange = [$name,$surname,$email,$number,$admin];
          $sql = "SELECT * from users WHERE user_id=?";
          $stmt = $this->conn->prepare($sql);
          $stmt->bind_param("s", $_GET["data"]);
          $stmt->execute();
          $results = $stmt->get_result();
          $row = $results->fetch_assoc();
          foreach ($toChange as $key => $value) {
            if($value["value"] != $row[$value["name"]]) {
              $sql = "UPDATE users SET ".$value['name']."=? WHERE user_id=?";
              $stmt = $this->conn->prepare($sql);
              $stmt->bind_param("ss", $value['value'], $_GET["data"]);
              $stmt->execute();
              $counter++;
            }
          }
          if($counter > 0) {
            $_SESSION["message"]["type"] = "success";
            $_SESSION["message"]["text"] = "Uspiješno ste promijenili podatke";
          }else {
            $_SESSION["message"]["type"] = "danger";
            $_SESSION["message"]["text"] = "Niste promijenili nijedno polje. Pokušajte ponovno";
          }
        }
      }
    }
  }
?>