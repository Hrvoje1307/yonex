<?php
  require "./vendor/autoload.php";

  use Orhanerday\OpenAi\OpenAi;

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
          "quantity" => $product["tocnaZaloga"],
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
              <td>".$product['quantity']."</td>
            </tr>
          ";
        }
      }
    }

    public function makeJson() {
      $json = array();
      $products = $this->getProducts();
      foreach ($products as $key => $product) {
        if($key<1) {
          array_push($json, [
            "ID" => $product['id'],
            "name" => $product['name'],
            "img_url" => $product["img"],
            "price" => $product["price"],
            "priceNOTAX" => $product["priceNOTAX"],
            "description" => $product["description"],
            "category" => $product["category"],
          ]);
        }
      }

      return json_encode($json);
    }

    public function productsTranslated() {
      $json = file_get_contents("./app/config/prijevod.json");
      $obj = json_decode($json, true);
      $productId = $obj[0]["ID"];
      $productName = $obj[0]["name"];
      $productImg = $obj[0]["img_url"];
      $productPrice = $obj[0]["price"];
      $productPriceNoTax = $obj[0]["priceNOTAX"];
      $productDescription = $obj[0]["description"];
      $productCategory = $obj[0]["category"];
      $productRacketWeight = $obj[0]["racketWeight"];
      $productRacketType = $obj[0]["racketType"];
      $productHandlerType = $obj[0]["handlerType"];
      $productQuantity = $obj[0]["quantity"];

      $sql = "INSERT INTO rackets (id, name, price, priceNOTAX, img_url, racketType, racketWeigth, handlerSize, quantity, category, description) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
      $stmt = $this->conn->prepare($sql);
      $stmt->bind_param("sssssssssss",$productId,$productName,$productPrice,$productPriceNoTax,$productImg,$productRacketType,$productRacketWeight,$productHandlerType,$productQuantity,$productCategory,$productDescription);
      $stmt->execute();
    }

    // public function aiTranslation($json) {
    //   // var_dump($json);
    //   $openAiKey = $_ENV["API_KEY_OPENAI"];
    //   $open_ai = new OpenAi($openAiKey);

    //   $chat = $open_ai->chat([
    //     'model' => 'gpt-3.5-turbo',
    //     'messages' => [
    //         [
    //             "role" => "user",
    //             "content" => "Translate everything from this $json from Slovenian to Croatian in JSON formatt"
    //         ]
    //     ],
    //     'temperature' => 1.0,
    //     'max_tokens' => 4000,
    //     'frequency_penalty' => 0,
    //     'presence_penalty' => 0,
    //   ]);
    //   $d = json_decode($chat);
    //   // Get Content
    //   echo($d->choices[0]->message->content);
    // }

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