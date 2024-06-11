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

    public function printProducts() {
      $products = $this->getProducts();

      foreach ($products as $key => $product) {
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
          <tr>
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
        echo $row;
      }
    }
  }
?>