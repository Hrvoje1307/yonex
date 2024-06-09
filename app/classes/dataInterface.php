<?php
  require "./vendor/autoload.php";


  class Model {
    protected $conn;
    public $dotenv;


    public function __construct() {
      global $conn;
      $this->conn = $conn;
      $this->dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
      $this->dotenv->load();
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
            <td>".$this->truncString($product["description"])."</td>
            <td>".$product['category']."</td>
          </tr>
        ";
      }
    }


    private function truncString($string, $length = 20, $append="...") {
      if(strlen($string) > $length) {
          $string =substr($string,0,$length).$append;
      }
      return $string;
  }
  }
?>