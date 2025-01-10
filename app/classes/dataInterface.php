<?php
  require "./vendor/autoload.php";

  use Orhanerday\OpenAi\OpenAi;

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

    public function getJson($path) {
      $json = file_get_contents($path);
      $obj = json_decode($json, true);

      return $obj;
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

    //GETTING JSON FROM SLOVENIA
    public function getProducts() {
      $xmlContent = [];
      $xmlFilePath = __DIR__ . '/../config/products.xml';
      $products = array();

      $dom = new DOMDocument();
      $dom->load($xmlFilePath);
      $productsXML = $dom->getElementsByTagName("izdelek");
      
      foreach ($productsXML as $key => $product) {
        array_push($products, [
        "position" => $key, 
        "id" => $product->getElementsByTagName("izdelekID")->item(0)->nodeValue,
        "name" => $product->getElementsByTagName("izdelekIme")->item(0)->nodeValue,
        "img" => isset($product->getElementsByTagName("slikaVelika")->item(0)->nodeValue) ? $product->getElementsByTagName("slikaVelika")->item(0)->nodeValue : null,
        "imgSmall" => isset($product->getElementsByTagName("slikaMala")->item(0)->nodeValue) ? $product->getElementsByTagName("slikaMala")->item(0)->nodeValue : null,
        "price" => $product->getElementsByTagName("PPC")->item(0)->nodeValue,
        "priceNOTAX" => $product->getElementsByTagName("nabavnaCena")->item(0)->nodeValue,
        "description" => $product->getElementsByTagName("opis")->item(0)->nodeValue,
        "category" => $product->getElementsByTagName("podkategorija")->item(0)->nodeValue,
        "quantity" => $product->getElementsByTagName("tocnaZaloga")->item(0)->nodeValue,
      ]);
      }
      return $products;
    }

    //MAKING MY OWN JSON TO TRANSLATE TO CROATIAN
    public function makeJson() {
      $classicFilters = ["Brisače", "Ostalo", "Šablone in črnila", "Dušilci vibracij", "Gripi", "Znojniki"];
      $rackets = ["Loparji"];
      $bags = ["Nahrbtniki", "Torbe"];
      $balls = ["Žogice"];
      $cords = ["Strune"];
      $shoes = ["Obutev"];
      $clothing = ["Nogavice", "Kratke hlače", "Majice", "Jakne", "Trenirke", "Obleke", "Ostalo-odijeća"];
      $json = ["classicFilters"=> array(), "rackets"=>array(), "bags"=>array(), "balls"=>array(), "cords"=>array(), "shoes"=>array(), "clothing"=>array()];
      $products = $this->getProducts();
      foreach ($products as $key => $product) {
        if(in_array($product["category"], $rackets)) { 
          array_push($json["rackets"], [
            "ID" => $product['id'],
            "name" => $product['name'],
            "img_url" => $product["img"],
            "price" => $product["price"],
            "priceNOTAX" => $product["priceNOTAX"],
            "description" => $product["description"],
            "category" => $product["category"],
            "quantity" => $product["quantity"],
          ]);
        }else if(in_array($product["category"], $classicFilters)) {
          array_push($json["classicFilters"], [
            "ID" => $product['id'],
            "name" => $product['name'],
            "img_url" => $product["img"],
            "price" => $product["price"],
            "priceNOTAX" => $product["priceNOTAX"],
            "description" => $product["description"],
            "category" => $product["category"],
            "quantity" => $product["quantity"],
          ]);
        }else if(in_array($product["category"], $bags)) {
          array_push($json["bags"], [
            "ID" => $product['id'],
            "name" => $product['name'],
            "img_url" => $product["img"],
            "price" => $product["price"],
            "priceNOTAX" => $product["priceNOTAX"],
            "description" => $product["description"],
            "category" => $product["category"],
            "quantity" => $product["quantity"],
          ]);
        }else if(in_array($product["category"], $balls)) {
          array_push($json["balls"], [
            "ID" => $product['id'],
            "name" => $product['name'],
            "img_url" => $product["img"],
            "price" => $product["price"],
            "priceNOTAX" => $product["priceNOTAX"],
            "description" => $product["description"],
            "category" => $product["category"],
            "quantity" => $product["quantity"],
          ]);
        }else if(in_array($product["category"], $cords)) {
          array_push($json["cords"], [
            "ID" => $product['id'],
            "name" => $product['name'],
            "img_url" => $product["img"],
            "price" => $product["price"],
            "priceNOTAX" => $product["priceNOTAX"],
            "description" => $product["description"],
            "category" => $product["category"],
            "quantity" => $product["quantity"],
          ]);
        }else if(in_array($product["category"], $shoes)) {
          array_push($json["shoes"], [
            "ID" => $product['id'],
            "name" => $product['name'],
            "img_url" => $product["img"],
            "price" => $product["price"],
            "priceNOTAX" => $product["priceNOTAX"],
            "description" => $product["description"],
            "category" => $product["category"],
            "quantity" => $product["quantity"],
          ]);
        }else if(in_array($product["category"], $clothing)) {
          array_push($json["clothing"], [
            "ID" => $product['id'],
            "name" => $product['name'],
            "img_url" => $product["img"],
            "price" => $product["price"],
            "priceNOTAX" => $product["priceNOTAX"],
            "description" => $product["description"],
            "category" => $product["category"],
            "quantity" => $product["quantity"],
          ]);
        }
      }

      file_put_contents("./app/config/productsMy.json", json_encode($json, JSON_PRETTY_PRINT));
    }
    
    public function getDataFunctions() {
      $dataArray = array();
      $counter = json_decode(file_get_contents("./app/config/counter.json"),true);
      $categories = ["classicFilters", "bags", "balls", "clothing", "cords", "rackets", "shoes"];

      foreach ($categories as $key => $category) {
        $lowercaseCategory = strtolower($category);
        $counterJson = json_decode(file_get_contents("./app/config/counter.json"),true)[$category];
        $dataCroatian = count($this->getJson("./app/config/prijevod.json")[$category]);
        $myJsonData = count($this->getJson("./app/config/productsMy.json")[$category]);
        $approvedTranslation = $counterJson >= (ceil($myJsonData/10)*10) ? "disabled" : ""; 
        $stmt = $this->conn->prepare("SELECT * from $lowercaseCategory");
        $stmt->execute();
        $result = $stmt->get_result();
        $resultDatabase = $result->num_rows;
        $approvedDataBase = $resultDatabase >= $dataCroatian ? "disabled" : "";

        array_push($dataArray,[
          "counter" =>$counterJson,
          "dataCroatian" =>$dataCroatian,
          "myJsonData" => $myJsonData,
          "approvedTranslation" => $approvedTranslation,
          "resultDatabase" => $resultDatabase,
          "approvedDataBase" => $approvedDataBase
        ]);
      }
      
      return $dataArray;
    }

    public function classicFilters() {
      $counterJson = json_decode(file_get_contents("./app/config/counter.json"),true);
      $counter = (int)$counterJson["classicFilters"];
      $batchSize = 10;
      $start = $counter;
      $end = $counter + $batchSize;
      $dataCroatian = $this->getJson("./app/config/prijevod.json");
      $classicFiltersArrayCroatian = $dataCroatian["classicFilters"];
      $myJsonData = $this->getJson("./app/config/productsMy.json");
      $classicFiltersProducts = $myJsonData["classicFilters"];
      $allowedCategories = ["vibrationDamper", "tints", "sweats", "gums", "towels", "restAccessories"];
      foreach ($classicFiltersProducts as $key => $product) {
        if($key >= $start && $key < $end) {
          $newName = $this->translateName($product["name"]);
          $newDescription = $this->translateDescription($product["description"]);
          $category = $this->getCategory($newName, $newDescription,$allowedCategories, "restAccessories");
          $croatianItem = [
            "ID" => $product["ID"],
            "name" => $newName,
            "img_url" => $product["img_url"],
            "price" => $product["price"],
            "priceNOTAX" => $product["priceNOTAX"],
            "description" => $newDescription,
            "quantity" => $product["quantity"],
            "category" => $category
          ];

          $itemExists = false;
          foreach ($classicFiltersArrayCroatian as $key => $item) {
            if($item["ID"] == $croatianItem["ID"]) {
              $itemExists = true;
              break;
            }
          }

          if(!$itemExists) {
            array_push($classicFiltersArrayCroatian, $croatianItem);
            $dataCroatian["classicFilters"] = $classicFiltersArrayCroatian; 
            file_put_contents("./app/config/prijevod.json", json_encode($dataCroatian, JSON_PRETTY_PRINT));
          }else {
            echo "NIJE DODANO<br/>";
          }
        }
      }
      $counter = $end;
      $counterJson["classicFilters"] = strval($counter);
      file_put_contents("./app/config/counter.json", json_encode($counterJson, JSON_PRETTY_PRINT));
    }

    public function rackets() {
      $counterJson = json_decode(file_get_contents("./app/config/counter.json"),true);
      $counter = (int)$counterJson["rackets"];
      $batchSize = 5;
      $start = $counter;
      $end = $counter + $batchSize;
      $dataCroatian = $this->getJson("./app/config/prijevod.json");
      $racketsArrayCroatian = $dataCroatian["rackets"];
      $myJsonData = $this->getJson("./app/config/productsMy.json");
      $racketsProducts = $myJsonData["rackets"];
      $allowedCategories = ["badminton", "tennis"];
      $allowedRacketTypeTennis = ["Ezoni", "Percept", "Vcore", "Vcore Pro"];
      $allowedRacketWeightTennis = ["240g", "250g","260g","270g","280g","290g","300g","310g","320g","330g","340g"];
      $allowedHandlerSizeTennis = ["G0","G1","G2","G3","G4"];
      $allowedRacketTypeBadminton = ["Arcsaber", "Astrox", "B-seria", "Duora","Muslce power", "Nanoflare","Nanozraci","Dječji","Voltric"];
      $allowedRacketWeightBadminton = ["2F = 68g", "2U = 90-94.9g","3U = 85-89.9g","4U = 80-84.9g","5U = 75-79.9g"];
      $allowedHandlerSizeBadminton = ["G4","G5","G7"];
      foreach ($racketsProducts as $key => $product) {
        if($key >= $start && $key < $end) {
          $newName = $this->translateName($product["name"]);
          $newDescription = $this->translateDescription($product["description"]);
          $category = $this->getCategory($newName, $newDescription,$allowedCategories, "tennis");
          if ($category == "tennis") {
            $allowedRacketTypes = $allowedRacketTypeTennis;
            $allowedRacketWeights = $allowedRacketWeightTennis;
            $allowedHandlerSizes = $allowedHandlerSizeTennis;
          } else {
            $allowedRacketTypes = $allowedRacketTypeBadminton;
            $allowedRacketWeights = $allowedRacketWeightBadminton;
            $allowedHandlerSizes = $allowedHandlerSizeBadminton;
          }

        $racketType = $this->getRacketType($newName, $newDescription, $allowedRacketTypes, $allowedRacketTypes[0]);
        $racketWeight = $this->getRacketWeight($newName, $newDescription, $allowedRacketWeights, $allowedRacketWeights[0]);
        $handlerSize = $this->getHandlerSize($newName, $newDescription, $allowedHandlerSizes, $allowedHandlerSizes[0]);

          $croatianItem = [
            "ID" => $product["ID"],
            "name" => $newName,
            "price" => $product["price"],
            "priceNOTAX" => $product["priceNOTAX"],
            "img_url" => $product["img_url"],
            "racketType" => $racketType,
            "racketWeight" => $racketWeight,
            "handlerSize" => $handlerSize,
            "quantity" => $product["quantity"],
            "category" => $category,
            "description" => $newDescription,
          ];

          $itemExists = false;
          foreach ($racketsArrayCroatian as $key => $item) {
            if($item["ID"] == $croatianItem["ID"]) {
              $itemExists = true;
              break;
            }
          }

          if(!$itemExists) {
            array_push($racketsArrayCroatian, $croatianItem);
            $dataCroatian["rackets"] = $racketsArrayCroatian; 
            file_put_contents("./app/config/prijevod.json", json_encode($dataCroatian, JSON_PRETTY_PRINT));
          }else {
            echo "NIJE DODANO<br/>";
          }
        }
      }
      $counter = $end;
      $counterJson["rackets"] = strval($counter);
      file_put_contents("./app/config/counter.json", json_encode($counterJson, JSON_PRETTY_PRINT));
    }

    public function bags() {
      $counterJson = json_decode(file_get_contents("./app/config/counter.json"),true);
      $counter = (int)$counterJson["bags"];
      $batchSize = 5;
      $start = $counter;
      $end = $counter + $batchSize;
      $dataCroatian = $this->getJson("./app/config/prijevod.json");
      $bagsArrayCroatian = $dataCroatian["bags"];
      $myJsonData = $this->getJson("./app/config/productsMy.json");
      $bagsProducts = $myJsonData["bags"];
      $allowedCategories = ["rucksack", "bags"];
      $allowedBagSizeRucksack = ["/"];
      $allowedBagTypeRucksack = ["/"];
      $allowedBagSizeBag = ["Ostale torbe", "3 reketa", "6 reketa", "8-12 reketa"];
      $allowedBagTypeBag = ["Aktivna", "Pro serija", "Timska serija"];
      foreach ($bagsProducts as $key => $product) {
        if($key >= $start && $key < $end) {
          $newName = $this->translateName($product["name"]);
          $newDescription = $this->translateDescription($product["description"]);
          $category = $this->getCategory($newName, $newDescription,$allowedCategories, $allowedCategories[0]);
          if ($category == $allowedCategories[0]) {
            $allowedBagSize = $allowedBagSizeRucksack;
            $allowedBagType = $allowedBagTypeRucksack;
          } else {
            $allowedBagSize = $allowedBagSizeBag;
            $allowedBagType = $allowedBagTypeBag;
          }

          $bagSize = $this->getBagSize($newName, $newDescription, $allowedBagSize, $allowedBagSize[0]);
          $bagType = $this->getProductType($newName, $newDescription, $allowedBagType, $allowedBagType[0]);

          $croatianItem = [
            "ID" => $product["ID"],
            "name" => $newName,
            "price" => $product["price"],
            "priceNOTAX" => $product["priceNOTAX"],
            "img_url" => $product["img_url"],
            "bagSize" => $bagSize,
            "bagType" => $bagType,
            "quantity" => $product["quantity"],
            "category" => $category,
            "description" => $newDescription,
          ];

          $itemExists = false;
          foreach ($bagsArrayCroatian as $key => $item) {
            if($item["ID"] == $croatianItem["ID"]) {
              $itemExists = true;
              break;
            }
          }

          if(!$itemExists) {
            array_push($bagsArrayCroatian, $croatianItem);
            $dataCroatian["bags"] = $bagsArrayCroatian; 
            file_put_contents("./app/config/prijevod.json", json_encode($dataCroatian, JSON_PRETTY_PRINT));
          }else {
            echo "NIJE DODANO<br/>";
          }
        }
      }
      $counter = $end;
      $counterJson["bags"] = strval($counter);
      file_put_contents("./app/config/counter.json", json_encode($counterJson, JSON_PRETTY_PRINT));
    }

    public function balls() {
      $counterJson = json_decode(file_get_contents("./app/config/counter.json"),true);
      $counter = (int)$counterJson["balls"];
      $batchSize = 5;
      $start = $counter;
      $end = $counter + $batchSize;
      $dataCroatian = $this->getJson("./app/config/prijevod.json");
      $ballsArrayCroatian = $dataCroatian["balls"];
      $myJsonData = $this->getJson("./app/config/productsMy.json");
      $ballsProducts = $myJsonData["balls"];
      $allowedCategories = ["badminton", "tennis"];
      $allowedBallTypeBadminton = ["Najlon", "Perje"];
      $allowedBallSpeedBadminton = ["Brze", "Brzina 3", "Srednje", "Spore"];
      $allowedBallTypeTennis = ["Turnir", "Trening"];
      $allowedBallSpeedTennis = ["/"];
      foreach ($ballsProducts as $key => $product) {
        if($key >= $start && $key < $end) {
          $newName = $this->translateName($product["name"]);
          $newDescription = $this->translateDescription($product["description"]);
          $category = $this->getCategory($newName, $newDescription,$allowedCategories, $allowedCategories[0]);
          if ($category == $allowedCategories[0]) {
            $allowedBallType = $allowedBallTypeBadminton;
            $allowedBallSpeed = $allowedBallSpeedBadminton;
          } else {
            $allowedBallType = $allowedBallTypeTennis;
            $allowedBallSpeed = $allowedBallSpeedTennis;
          }

          $ballType = $this->getProductType($newName, $newDescription, $allowedBallType, $allowedBallType[0]);
          $ballSpeed = $this->getBallSpeed($newName, $newDescription, $allowedBallSpeed, $allowedBallSpeed[0]);

          $croatianItem = [
            "ID" => $product["ID"],
            "name" => $newName,
            "price" => $product["price"],
            "priceNOTAX" => $product["priceNOTAX"],
            "img_url" => $product["img_url"],
            "ballType" => $ballType,
            "ballSpeed" => $ballSpeed,
            "quantity" => $product["quantity"],
            "category" => $category,
            "description" => $newDescription,
          ];

          $itemExists = false;
          foreach ($ballsArrayCroatian as $key => $item) {
            if($item["ID"] == $croatianItem["ID"]) {
              $itemExists = true;
              break;
            }
          }

          if(!$itemExists) {
            array_push($ballsArrayCroatian, $croatianItem);
            $dataCroatian["balls"] = $ballsArrayCroatian; 
            file_put_contents("./app/config/prijevod.json", json_encode($dataCroatian, JSON_PRETTY_PRINT));
          }else {
            echo "NIJE DODANO<br/>";
          }
        }
      }
      $counter = $end;
      $counterJson["balls"] = strval($counter);
      file_put_contents("./app/config/counter.json", json_encode($counterJson, JSON_PRETTY_PRINT));
    }

    public function cords() {
      $counterJson = json_decode(file_get_contents("./app/config/counter.json"),true);
      $counter = (int)$counterJson["cords"];
      $batchSize = 10;
      $start = $counter;
      $end = $counter + $batchSize;
      $dataCroatian = $this->getJson("./app/config/prijevod.json");
      $cordsArrayCroatian = $dataCroatian["cords"];
      $myJsonData = $this->getJson("./app/config/productsMy.json");
      $cordsProducts = $myJsonData["cords"];
      $allowedCategories = ["badminton", "tennis"];
      $allowedThicknessesTennis = ["1.15 mm", "1.20 mm", "1.25 mm", "1.30 mm"];
      $allowedLengthTennis = ["Role [200m-500m]", "12m"];
      $allowedThicknessesBadminton = ["/"];
      $allowedLengthBadminton = ["Role [200m-500m]", "10m"];
      foreach ($cordsProducts as $key => $product) {
        if($key >= $start && $key < $end) {
          $newName = $this->translateName($product["name"]);
          $newDescription = $this->translateDescription($product["description"]);
          $category = $this->getCategory($newName, $newDescription,$allowedCategories, $allowedCategories[0]);
          if ($category == $allowedCategories[0]) {
            $allowedThicknesses = $allowedThicknessesBadminton;
            $allowedLength = $allowedLengthBadminton;
          } else {
            $allowedThicknesses = $allowedThicknessesTennis;
            $allowedLength = $allowedLengthTennis;
          }

          $cordThickness = $this->getThicknesses($newName, $newDescription, $allowedThicknesses, $allowedThicknesses[0]);
          $cordLength = $this->getLength($newName, $newDescription, $allowedLength, $allowedLength[0]);

          $croatianItem = [
            "ID" => $product["ID"],
            "name" => $newName,
            "price" => $product["price"],
            "priceNOTAX" => $product["priceNOTAX"],
            "img_url" => $product["img_url"],
            "cordThickness" => $cordThickness,
            "cordLength" => $cordLength,
            "quantity" => $product["quantity"],
            "category" => $category,
            "description" => $newDescription,
          ];

          $itemExists = false;
          foreach ($cordsArrayCroatian as $key => $item) {
            if($item["ID"] == $croatianItem["ID"]) {
              $itemExists = true;
              break;
            }
          }

          if(!$itemExists) {
            array_push($cordsArrayCroatian, $croatianItem);
            $dataCroatian["cords"] = $cordsArrayCroatian; 
            file_put_contents("./app/config/prijevod.json", json_encode($dataCroatian, JSON_PRETTY_PRINT));
          }else {
            echo "NIJE DODANO<br/>";
          }
        }
      }
      $counter = $end;
      $counterJson["cords"] = strval($counter);
      file_put_contents("./app/config/counter.json", json_encode($counterJson, JSON_PRETTY_PRINT));
    }

    public function shoes() {
      $counterJson = json_decode(file_get_contents("./app/config/counter.json"),true);
      $counter = (int)$counterJson["shoes"];
      $batchSize = 5;
      $start = $counter;
      $end = $counter + $batchSize;
      $dataCroatian = $this->getJson("./app/config/prijevod.json");
      $shoesArrayCroatian = $dataCroatian["shoes"];
      $myJsonData = $this->getJson("./app/config/productsMy.json");
      $shoesProducts = $myJsonData["shoes"];
      $allowedCategories = ["badminton", "tennis"];
      $allowedShoesSize = ["36", "36.5", "37", "37.5", "38", "38.5", "39", "39.5", "40", "40.5", "41", "41.5", "42", "42.5", "43", "43.5", "44", "44.5", "45", "45.5", "46", "46.5", "47"];
      $allowedShoesSex = ["Muški", "Ženski", "Uniseks"];
      foreach ($shoesProducts as $key => $product) {
        if($key >= $start && $key < $end) {
          $newName = $this->translateName($product["name"]);
          $newDescription = $this->translateDescription($product["description"]);
          $category = $this->getCategory($newName, $newDescription,$allowedCategories, $allowedCategories[0]);
          $shoeSize = $this->getProductSize($newName, $newDescription, $allowedShoesSize, $allowedShoesSize[8]);
          $shoeSex = $this->getProductSex($newName, $newDescription, $allowedShoesSex, $allowedShoesSex[0]);
          
          $croatianItem = [
            "ID" => $product["ID"],
            "name" => $newName,
            "price" => $product["price"],
            "priceNOTAX" => $product["priceNOTAX"],
            "img_url" => $product["img_url"],
            "shoeSize" => $shoeSize,
            "shoeSex" => $shoeSex,
            "quantity" => $product["quantity"],
            "category" => $category,
            "description" => $newDescription,
          ];

          $itemExists = false;
          foreach ($shoesArrayCroatian as $key => $item) {
            if($item["ID"] == $croatianItem["ID"]) {
              $itemExists = true;
              break;
            }
          }

          if(!$itemExists) {
            array_push($shoesArrayCroatian, $croatianItem);
            $dataCroatian["shoes"] = $shoesArrayCroatian; 
            file_put_contents("./app/config/prijevod.json", json_encode($dataCroatian, JSON_PRETTY_PRINT));
          }else {
            echo "NIJE DODANO<br/>";
          }
        }
      }
      $counter = $end;
      $counterJson["shoes"] = strval($counter);
      file_put_contents("./app/config/counter.json", json_encode($counterJson, JSON_PRETTY_PRINT));
    }

    public function clothing() {
      $counterJson = json_decode(file_get_contents("./app/config/counter.json"),true);
      $counter = (int)$counterJson["clothing"];
      $batchSize = 10;
      $start = $counter;
      $end = $counter + $batchSize;
      $dataCroatian = $this->getJson("./app/config/prijevod.json");
      $clothingArrayCroatian = $dataCroatian["clothing"];
      $myJsonData = $this->getJson("./app/config/productsMy.json");
      $clothingProducts = $myJsonData["clothing"];
      $allowedCategories = ["jackets", "socks", "rest", "shorts", "t-shirts", "sweatpants", "dress"];
      $allowedSizes = ["S", "M", "L", "XL", "XXL"];
      $allowedClothingSex = ["Muški", "Ženski", "Uniseks"];
      foreach ($clothingProducts as $key => $product) {
        if($key >= $start && $key < $end) {
          $slovenianCategory = $product["category"];
          $newName = $this->translateName($product["name"]);
          $newDescription = $this->translateDescription($product["description"]);
          $category = $this->getCategoryClothing($newName, $newDescription, $slovenianCategory, $allowedCategories, $allowedCategories[0]);
          $clothingSize = $this->getProductSize($newName, $newDescription, $allowedSizes, $allowedSizes[0]);
          $clothingSex = $this->getProductSex($newName, $newDescription, $allowedClothingSex, $allowedClothingSex[0]);
          
          $croatianItem = [
            "ID" => $product["ID"],
            "name" => $newName,
            "price" => $product["price"],
            "priceNOTAX" => $product["priceNOTAX"],
            "img_url" => $product["img_url"],
            "clothingSize" => $clothingSize,
            "clothingSex" => $clothingSex,
            "quantity" => $product["quantity"],
            "category" => $category,
            "description" => $newDescription,
          ];

          $itemExists = false;
          foreach ($clothingArrayCroatian as $key => $item) {
            if($item["ID"] == $croatianItem["ID"]) {
              $itemExists = true;
              break;
            }
          }

          if(!$itemExists) {
            array_push($clothingArrayCroatian, $croatianItem);
            $dataCroatian["clothing"] = $clothingArrayCroatian; 
            file_put_contents("./app/config/prijevod.json", json_encode($dataCroatian, JSON_PRETTY_PRINT));
          }else {
            echo "NIJE DODANO<br/>";
          }
        }
      }
      $counter = $end;
      $counterJson["clothing"] = strval($counter);
      file_put_contents("./app/config/counter.json", json_encode($counterJson, JSON_PRETTY_PRINT));
    }

    public function callTrainslationFunctions() {
      if(isset($_SERVER['REQUEST_METHOD']) ) {
        if(isset($_POST["classicFiltersTranslation"])) {
          return $this->classicFilters();
        }else if(isset($_POST["classicFiltersDataBase"])) {
          return $this->productsTranslatedClassicFilters();
        }else if(isset($_POST["racketsTranslation"])) {
          return $this->rackets();
        }else if(isset($_POST["racketsDataBase"])) {
          return $this->productTranslatedRackets();
        }else if(isset($_POST["bagsTranslation"])) {
          return $this->bags();
        }else if(isset($_POST["bagsDataBase"])) {
          return $this->productTranslatedBags();
        }else if(isset($_POST["ballsTranslation"])) {
          return $this->balls();
        }else if(isset($_POST["ballsDataBase"])) {
          return $this->productTranslatedBalls();
        }else if(isset($_POST["cordsTranslation"])) {
          return $this->cords();
        }else if(isset($_POST["cordsDataBase"])) {
          return $this->productTranslatedCords();
        }else if(isset($_POST["shoesTranslation"])) {
          return $this->shoes();
        }else if(isset($_POST["shoesDataBase"])) {
          return $this->productTranslatedShoes();
        }else if(isset($_POST["clothingTranslation"])) {
          return $this->clothing();
        }else if(isset($_POST["clothingDataBase"])) {
          return $this->productTranslatedClothing();
        }
      }
    }

    public function translateName($name) {
      return $this->aiTranslation("Translate the following product name 
      from Slovenian to Croatian. Only provide the translation, nothing else. Example input: 
        'Brisača AC1110, črna/mint'. Example output: 'Ručnik AC1110, crna/mint'. Input: '".$name."'");
    }

    public function translateDescription($description) {
      return $this->aiTranslation("Translate the following product description from Slovenian to Croatian. Only provide the translation, nothing else. Input: '".$description."'");
    }

    public function getCategory($newName,$newDescription,$allowedCategories, $alternativeCategory) {
      $category = $this->aiTranslation("Determine the category for this product based on its name and description. The category must be one of the following: ".implode(", ",$allowedCategories).". Only provide the category name, nothing else. Example input: Name: 'Ručnik AC1110, crna/mint'. Description: 'Pamuk ručnik koji upija znoj'. Example output: 'towels'. Input Name: '".$newName."'. Input Description: '".$newDescription."'.");

      if (!in_array($category, $allowedCategories)) {
          $category = $alternativeCategory;
      }
      return $category;
    }

    public function getCategoryClothing($newName,$newDescription,$slovenianCategory, $allowedCategories, $alternativeCategory) {
      $category = $this->aiTranslation("Determine the category for this product based on its name and description. You also have $slovenianCategory that you can translate to Croatian to get the category. The category must be one of the following: ".implode(", ",$allowedCategories).". Only provide the category name, nothing else. 
      Example input: Name: 'Ručnik AC1110, crna/mint'. Description: 'Pamuk ručnik koji upija znoj'. Example output: 'towels'.Input Name: '".$newName."'. 
      Input Description: '".$newDescription."'.");

      if (!in_array($category, $allowedCategories)) {
          $category = $alternativeCategory;
      }
      return $category;
    }

    public function getRacketType($newName, $newDescription, $allowedRacketTypes, $alternativeRacketType) {
      $message ="Determine the racket type for this product based on its name and description. The racket type must be one of the following: ".implode(", ",$allowedRacketTypes).". 
                Only provide the racket type, nothing else. Example input: Name: 'Yonex Nanoray 20'. Description: 'Lightweight badminton racket with high repulsion power'. 
                Example output: 'Voltric'.Input Name: '".$newName."'. Input Description: '".$newDescription."'.";
      $racketType = $this->aiTranslation($message);
      if (!in_array($racketType, $allowedRacketTypes)) {
        $racketType = $alternativeRacketType;
      }
      return $racketType;
    }

    public function getRacketWeight($newName, $newDescription, $allowedRacketWeights, $alternativeRacketWeight) {
      $message = "Determine the racket weight for this product based on its name and description. The racket weight must be one of the following: ".implode(", ",$allowedRacketWeights).". 
                Only provide the racket weight, nothing else. Example input: Name: 'Yonex Nanoray 20'. Description: 'Lightweight badminton racket with high repulsion power, 3U = 95-89.9g'. 
                Example output: '3U = 95-89.9g'.Example input: Name: 'Yonex Nanoray 20'. Description: 'Lightweight badminton racket with high repulsion power, 280g'. 
                Example output: '280g'Input Name: '".$newName."'. 
                Input Description: '".$newDescription."'.";
      $racketWeight = $this->aiTranslation($message);
      if(!in_array($racketWeight, $allowedRacketWeights)) {
        $racketWeight = $alternativeRacketWeight;
      }

      return $racketWeight;
    }

    public function getHandlerSize($newName, $newDescription, $allowedHandlerSizes, $alternativeHandlerSize) {
      $message = "Determine the handler size for this product based on its name and description. The handler size must be one of the following: ".implode(", ", $allowedHandlerSizes).". 
                  Only provide the handler size, nothing else. Example input: Name: 'Yonex Nanoray 20'. Description: 'Lightweight badminton racket with high repulsion power, comes with a G4 handle'. 
                  Example output: 'G4'.Input Name: '".$newName."'. 
                  Input Description: '".$newDescription."'.";
          
      $handlerSize = $this->aiTranslation($message);
      if(!in_array($handlerSize, $allowedHandlerSizes)) {
        $handlerSize = $alternativeHandlerSize;
      }

      return $handlerSize;
    }

    public function getBagSize($newName, $newDescription, $allowedBagSizes, $alternativeBagSize) {
      $message = "Determine the bag size for this product based on its name and description. The bag size must be one of the following: ".implode(", ", $allowedBagSizes).". 
                  Only provide the bag size, nothing else.
                  Example input: Name: 'Yonex Pro Tournament Bag'. Description: 'Velika teniska torba koja može držati do 6 reketa'. Example output: '6 reketa'.
                  Input Name: '".$newName."'. 
                  Input Description: '".$newDescription."'.";

      $bagSize = $this->aiTranslation($message);
      if(!in_array($bagSize,$allowedBagSizes)) {
        $bagSize = $alternativeBagSize;
      }

      return $bagSize;
    }

    public function getProductType($newName, $newDescription, $allowedProductTypes, $alternativeProductType) {
      $message = "Determine the bag type for this product based on its name and description. The bag type must be one of the following: ".implode(", ", $allowedProductTypes).". 
                  Only provide the bag type, nothing else.
                  Example input: Name: 'Yonex Pro Tournament Bag'. Description: 'Profesionalna torba za turnire'. Example output: 'Pro serija'.
                  Example input: Name: 'Lopte za badminton MAVIS 350 1/6, bijele, brze'. Description: 'Po letu i osjećaju lopta je najsličnija lopti 
                  od perja. Tvrdoća krila - pernatog dijela najlonske lopte - mijenja se s temperaturom.'. Example output: 'Perje'.
                  Input Name: '".$newName."'. 
                  Input Description: '".$newDescription."'.";

      $productType = $this->aiTranslation($message);
      if(!in_array($productType,$allowedProductTypes)) {
        $productType = $alternativeProductType;
      }

      return $productType;
    }

    public function getBallSpeed($newName, $newDescription, $allowedBallSpeeds, $alternativeBallSpeed) {
      $message = "Determine the ball speed for this product based on its name and description. The ball speed must be one of the following: ".implode(", ", $allowedBallSpeeds).". 
                  Only provide the ball speed, nothing else.Example input: Name: 'Yonex Aerosensa 30'. Description: 'Brzi badminton loptice za turnire'. Example output: 'Brze'.
                  Input Name: '".$newName."'. 
                  Input Description: '".$newDescription."'.";

      $ballSpeed = $this->aiTranslation($message);
      if(!in_array($ballSpeed,$allowedBallSpeeds)) {
        $ballSpeed = $alternativeBallSpeed;
      }

      return $ballSpeed;
    }

    public function getThicknesses($newName, $newDescription, $allowedThicknesses, $alternativeThicknesses) {
      $message = "Determine the cord thickness for this product based on its name and description. The cord thickness must be one of the following: ".implode(", ", $allowedThicknesses).". 
                  Only provide the cord thickness, nothing else. 
                  Example input: Name: 'Wilson Sensation 16'. Description: 'Teniska žica promjera 1.30mm za optimalan osjećaj'. Example output: '1.30mm'.
                  Input Name: '".$newName."'. 
                  Input Description: '".$newDescription."'.";

      $cordThicknesses = $this->aiTranslation($message);
      if(!in_array($cordThicknesses, $allowedThicknesses)) {
        $cordThicknesses = $alternativeThicknesses;
      }

      return $cordThicknesses;
    }

    public function getLength($newName, $newDescription, $allowedCordLengths, $alternativeCordLength) {
      $message = "Determine the cord length for this product based on its name and description. The cord length must be one of the following: ".implode(", ", $allowedCordLengths).". 
                  Only provide the cord length, nothing else.
                  Example input: Name: 'Yonex BG65'. Description: 'Visokokvalitetna badmintonska žica duljine 10m za dugotrajnost'. Example output: '10m'.
                  Input Name: '".$newName."'. 
                  Input Description: '".$newDescription."'.";

      $cordLength = $this->aiTranslation($message);
      if(!in_array($cordLength, $allowedCordLengths)) {
        $cordLength = $alternativeCordLength;
      }

      return $cordLength;
    }

    public function getProductSize($newName, $newDescription, $allowedProductSize, $alternativeProductSize) {
      $message = "Determine the shoe size for this product based on its name and description. The shoe size must be one of the following: ".implode(", ", $allowedProductSize).". Only provide the shoe size, nothing else. 
                  Example input: Name: 'Yonex Power Cushion 65'. Description: 'Profesionalne badmintonske tenisice veličine 42'. Example output: '42'.
                  Example input: Name: 'Yonex Tournament Shirt'. Description: 'Profesionalna badmintonska majica veličine L'. Example output: 'L'.
                  Input Name: '".$newName."'. 
                  Input Description: '".$newDescription."'.";

      $productSize = $this->aiTranslation($message);
      if(!in_array($productSize, $allowedProductSize)) {
        $productSize = $alternativeProductSize;
      }

      return $productSize;
    }

    public function getProductSex($newName, $newDescription, $allowedProductSex, $alternativeProductSex) {
      $message = "Determine the shoe sex for this product based on its name and description. The shoe sex must be one of the following: ".implode(", ", $allowedProductSex).". Only provide the shoe sex, nothing else. 
                  Example input: Name: 'Yonex Power Cushion 65'. Description: 'Profesionalne badmintonske tenisice za muškarce'. Example output: 'Muški'.
                  Input Name: '".$newName."'. 
                  Input Description: '".$newDescription."'.";

      $productSex = $this->aiTranslation($message);
      if(!in_array($productSex, $allowedProductSex)) {
        $productSex = $alternativeProductSex;
      }

      return $productSex;
    }

    public function productsTranslatedClassicFilters() {
      $json = $this->getJson("./app/config/prijevod.json")["classicFilters"];
      foreach ($json as $key => $product) {
          $productId = $product["ID"];
          $productName = $product["name"];
          $productImg = $product["img_url"];
          $productPrice = $product["price"];
          $productPriceNoTax = $product["priceNOTAX"];
          $productDescription = $product["description"];
          $productQuantity = $product["quantity"];
          $productCategory = $product["category"];
          $sql = "INSERT INTO classicfilters (id, name, price, priceNOTAX, img_url, quantity, category, description) VALUES (?,?,?,?,?,?,?,?)";
          $stmt = $this->conn->prepare($sql);
          $stmt->bind_param("ssssssss",$productId,$productName,$productPrice,$productPriceNoTax,$productImg,$productQuantity,$productCategory,$productDescription);
          $stmt->execute();
      }
    }

    public function productTranslatedRackets() {
      $json = $this->getJson("./app/config/prijevod.json")["rackets"];
      foreach ($json as $key => $product) {
        $productId = $product["ID"];
        $productName = $product["name"];
        $productImg = $product["img_url"];
        $productPrice = $product["price"];
        $productPriceNoTax = $product["priceNOTAX"];
        $productDescription = $product["description"];
        $productQuantity = $product["quantity"];
        $productCategory = $product["category"];
        $productRacketType = $product["racketType"];
        $productRacketWeight = $product["racketWeight"];
        $productHandlerSize = $product["handlerSize"];
        $sql = "INSERT INTO rackets (id, name, price, priceNOTAX, img_url, quantity, category, description, racketType, racketWeight, handlerSize) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssssssssss",$productId,$productName,$productPrice,$productPriceNoTax,$productImg,$productQuantity,$productCategory,$productDescription, $productRacketType, $productRacketWeight, $productHandlerSize);
        $stmt->execute();
      }
    }

    public function productTranslatedBags() {
      $json = $this->getJson("./app/config/prijevod.json")["bags"];
      foreach ($json as $key => $product) {
        $productId = $product["ID"];
        $productName = $product["name"];
        $productImg = $product["img_url"];
        $productPrice = $product["price"];
        $productPriceNoTax = $product["priceNOTAX"];
        $productDescription = $product["description"];
        $productQuantity = $product["quantity"];
        $productCategory = $product["category"];
        $productBagSize = $product["bagSize"];
        $productBagType = $product["bagType"];
        $sql = "INSERT INTO bags (id, name, price, priceNOTAX, img_url, quantity, category, description, size, type) VALUES (?,?,?,?,?,?,?,?,?,?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssssssss",$productId,$productName,$productPrice,$productPriceNoTax,$productImg,$productQuantity,$productCategory,$productDescription, $productBagSize, $productBagType);
        $stmt->execute();
      }
    }

    public function productTranslatedBalls() {
      $json = $this->getJson("./app/config/prijevod.json")["balls"];
      foreach ($json as $key => $product) {
        $productId = $product["ID"];
        $productName = $product["name"];
        $productImg = $product["img_url"];
        $productPrice = $product["price"];
        $productPriceNoTax = $product["priceNOTAX"];
        $productDescription = $product["description"];
        $productQuantity = $product["quantity"];
        $productCategory = $product["category"];
        $productBallType = $product["ballType"];
        $productBallSpeed = $product["ballSpeed"];
        $sql = "INSERT INTO balls (id, name, price, priceNOTAX, img_url, quantity, category, description, speed, type) VALUES (?,?,?,?,?,?,?,?,?,?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssssssss",$productId,$productName,$productPrice,$productPriceNoTax,$productImg,$productQuantity,$productCategory,$productDescription, $productBallSpeed, $productBallType);
        $stmt->execute();
      }
    }

    public function productTranslatedCords() {
      $json = $this->getJson("./app/config/prijevod.json")["cords"];
      foreach ($json as $key => $product) {
        $productId = $product["ID"];
        $productName = $product["name"];
        $productImg = $product["img_url"];
        $productPrice = $product["price"];
        $productPriceNoTax = $product["priceNOTAX"];
        $productDescription = $product["description"];
        $productQuantity = $product["quantity"];
        $productCategory = $product["category"];
        $productThickness = $product["cordThickness"];
        $productLength = $product["cordLength"];
        $sql = "INSERT INTO cords (id, name, price, priceNOTAX, img_url, quantity, category, description, thicknesses, length) VALUES (?,?,?,?,?,?,?,?,?,?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssssssss",$productId,$productName,$productPrice,$productPriceNoTax,$productImg,$productQuantity,$productCategory,$productDescription, $productThickness, $productLength);
        $stmt->execute();
      }
    }

    public function productTranslatedShoes() {
      $json = $this->getJson("./app/config/prijevod.json")["shoes"];
      foreach ($json as $key => $product) {
        $productId = $product["ID"];
        $productName = $product["name"];
        $productImg = $product["img_url"];
        $productPrice = $product["price"];
        $productPriceNoTax = $product["priceNOTAX"];
        $productDescription = $product["description"];
        $productQuantity = $product["quantity"];
        $productCategory = $product["category"];
        $productShoesSize = $product["shoeSize"];
        $productShoesSex = $product["shoeSex"];
        $sql = "INSERT INTO shoes (id, name, price, priceNOTAX, img_url, quantity, category, description, shoes_num, sex) VALUES (?,?,?,?,?,?,?,?,?,?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssssssss",$productId,$productName,$productPrice,$productPriceNoTax,$productImg,$productQuantity,$productCategory,$productDescription, $productShoesSize, $productShoesSex);
        $stmt->execute();
      }
    }

    public function productTranslatedClothing() {
      $json = $this->getJson("./app/config/prijevod.json")["clothing"];
      foreach ($json as $key => $product) {
        $productId = $product["ID"];
        $productName = $product["name"];
        $productImg = $product["img_url"];
        $productPrice = $product["price"];
        $productPriceNoTax = $product["priceNOTAX"];
        $productDescription = $product["description"];
        $productQuantity = $product["quantity"];
        $productCategory = $product["category"];
        $productClothingSize = $product["clothingSize"];
        $productClothingsSex = $product["clothingSex"];
        $sql = "INSERT INTO clothing (id, name, price, priceNOTAX, img_url, quantity, category, description, size, sex) VALUES (?,?,?,?,?,?,?,?,?,?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssssssss",$productId,$productName,$productPrice,$productPriceNoTax,$productImg,$productQuantity,$productCategory,$productDescription, $productClothingSize, $productClothingsSex);
        $stmt->execute();
      }
    }

    public function aiTranslation($message) {
      $openAiKey = $_ENV["API_KEY_OPENAI"];
      $open_ai = new OpenAi($openAiKey);

      $chat = $open_ai->chat([
        'model' => 'gpt-3.5-turbo',
        'messages' => [
            [
                "role" => "user",
                "content" => $message
            ]
        ],
        'temperature' => 1.0,
        'max_tokens' => 4000,
        'frequency_penalty' => 0,
        'presence_penalty' => 0,
      ]);
      $d = json_decode($chat, true);
      $result = $d['choices'][0]['message']['content']; 
      return $result;
    }

    public function printProducts() {
      $pageNum = $this->getInfoProducts()["pageNum"];
      $min = ($pageNum * $_ENV["PRODUCTS_PER_PAGE"]) - $_ENV["PRODUCTS_PER_PAGE"];
      $max = ($pageNum * $_ENV["PRODUCTS_PER_PAGE"]) -1;
      $products = $this->getProducts();
      foreach ($products as $key => $product) {
        if($key >= $min && $key <= $max) {
          $product["position"] = strval(((int)$product["position"]) + 1);
          echo "
            <tr>
              <td>".$product['position']."</td>
              <td>".$product['id']."</td>
              <td>".$product['name']."</td>
              <td><img src=".$product["imgSmall"]."></td>
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

    public function getProductTable($product_id) {
      $tables = ["classicfilters", "bags", "balls", "clothing", "cords", "rackets", "shoes"];
      foreach ($tables as $key => $table) {
        $sql = "SELECT * FROM $table WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s",$product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0) {
         return $table;
        }
      }
    }

    public function getDataFromEachProduct($product_id) {
      $table = $this->getProductTable($product_id);
      $sql = "SELECT * FROM $table WHERE id=?"; 
      $stmt = $this->conn->prepare($sql);
      $stmt->bind_param("s",$product_id);
      $stmt->execute();
      $result = $stmt->get_result();
      $data = $result->fetch_assoc();
      return $data;
    }

    public function makeRadioButtons($array, $checkField,$label,$name) {
      if(!$array) return;
      $code="";
      $code.= "
        <div class='mb-3'>
          <label for='productCategory' class='form-label'>$label</label>
          <div class='d-flex gap-5 flex-wrap my-3'>
      ";
      foreach ($array as $key => $filter) {
        $checked = $filter === htmlspecialchars(trim($checkField)) ? "checked" : null;
        $code.="
            <div class='mb-3 form-check'>
              <input type='radio' class='form-check-input product-input__field' name='$name' id='$name$key' value='$filter' ".$checked.">
              <label class='form-check-label' for='$name$key'>$filter</label>
            </div>
        ";
      }
      $code.= "
         </div>
        </div>
      ";

      return $code;
    }

    public function printProductForm($product_id) {
      $table = $this->getProductTable($product_id);
      $categories = ["classicfilters" => ["vibrationDamper", "tints", "sweats", "gums", "towels", "restAccessories"], 
      "rackets" => ["tennis", "badminton"], "bags" => ["rucksack", "bags"], "cords" => ["tennis", "badminton"], 
      "clothing" => ["jackets", "socks", "rest", "shorts", "t-shirts", "sweatpants", "dress"], "shoes" => ["tennis", "badminton"],
      "balls" => ["tennis", "badminton"]];
      $productData = $this->getDataFromEachProduct($product_id);
      $code = "";
      $code.= "
        <h3 class='mt-5'>Osnovni podatci</h3>
        <hr>
        <img style='width:20rem' src='".$productData["img_url"]."' class='img-thumbnail my-3' alt='Product image'>
        <div class='mb-3'>
          <label for='productId' class='form-label'>ID proizvoda</label>
          <input type='text' name='ID' class='form-control product-input__field' id='productId' value='".htmlspecialchars(trim($productData["id"]))."' readonly='true'>
        </div>
        <div class='mb-3'>
          <label for='productName' class='form-label'>Ime</label>
          <input type='text' name='name' class='form-control product-input__field' id='productName' value='".htmlspecialchars(trim($productData["name"]))."'>
        </div>
        <div class='mb-3'>
          <label for='productImgUrl' class='form-label'>Url slike</label>
          <input type='text' name='img_url' class='form-control product-input__field' id='productImgUrl' value='".htmlspecialchars(trim($productData["img_url"]))."'>
        </div>
        <div class='mb-3'>
          <label for='price' class='form-label'>Cijena</label>
          <div class='input-group mb-3'>
            <input name='price' type='text' class='form-control product-input__field' id='price' value='".htmlspecialchars(trim($productData["price"]))."'>
            <label  class='input-group-text bg-primary text-light' for='price'>€</label>
          </div>
        </div>
        <div class='mb-3'>
          <label for='priceNoTax' class='form-label'>Nabavna cijena</label>
          <div class='input-group mb-3'>
            <input type='text' name='priceNoTax' class='form-control product-input__field' id='priceNoTax' value='".htmlspecialchars(trim($productData["priceNOTAX"]))."'>
            <label class='input-group-text bg-primary text-light' for='priceNoTax'>€</label>
          </div>
        </div>
        <div class='mb-3'>
          <label for='productDescription' class='form-label'>Opis</label>
          <input type='text' name='description' class='form-control product-input__field' id='productDescription' value='".htmlspecialchars(trim($productData["description"]))."'>
        </div>";
      $code.= $this->makeRadioButtons($categories[$table], $productData["category"], "Kategorija proizvoda","category");
      $code.="
        <div class='mb-3'>
          <label for='productQuantity' class='form-label'>Količina</label>
          <input type='number' name='quantity' class='form-control product-input__field' id='productQuantity' value='".htmlspecialchars(trim($productData["quantity"]))."'>
        </div>
      ";

      if($table === "rackets") {
        $racketType = ["tennis" => ["Ezoni","Percept","Vcore","Vcore Pro"], 
                       "badminton" => ["Arcsaber","Astrox","B-seria","Duora","Muscle power","Nanoflare","Nanozraci","Dječji","Voltric"]];
        $racketWeight = ["tennis" => ["240g","250g","260g","270g","280g","290g","300g","310g","320g","330g","340g"], 
                        "badminton" => ["2F = 68g","2U = 90-94.9g","3U = 85-89.9g","4U = 80-84.9g","5U = 75-79.9g"]];
        $handlerSize = ["tennis" => ["G0","G1","G2","G3","G4"], "badminton" => ["G4", "G5", "G7"]];
        $code.= "
        <h3 class='mt-5'>Filteri</h3>
        <hr>";
        $code.= $this->makeRadioButtons($racketType[$productData["category"]], $productData["racketType"], "Tip reketa","racketType");
        $code.= $this->makeRadioButtons($racketWeight[$productData["category"]], $productData["racketWeight"], "Tezina reketa", "racketWeight");
        $code.= $this->makeRadioButtons($handlerSize[$productData["category"]], $productData["handlerSize"], "Veličina ručke", "handlerSize");
      }
      
      if($table === "bags") {
        $code.= "
        <h3 class='mt-5'>Filteri</h3>
        <hr>";
        $bagSize = ["rucksack" => [], "bags" => ["3 reketa", "6 reketa", "8-12 reketa", "Ostale torbe"]];
        $bagType = ["rucksack" => [], "bags" => ["Aktivna", "Pro serija", "Timska serija"]];
        $code.= $this->makeRadioButtons($bagSize[$productData["category"]], $productData["size"], "Veličina torbe", "bagSize");
        $code.= $this->makeRadioButtons($bagType[$productData["category"]], $productData["type"], "Veličina torbe", "bagType");
      }
      
      if($table === "cords") {
        $code.= "
        <h3 class='mt-5'>Filteri</h3>
        <hr>";
        $cordThickness = ["tennis" => ["1.15 mm", "1.20 mm", "1.25 mm" ,"1.30 mm"], "badminton" => []];
        $cordLength = ["tennis" => ["Role [200m-500m]","12m"], "badminton" => ["Role [200m-500m]","10m"]];
        $code.= $this->makeRadioButtons($cordThickness[$productData["category"]], $productData["thicknesses"], "Debljina žice", "cordThickness");
        $code.= $this->makeRadioButtons($cordLength[$productData["category"]], $productData["length"], "Duljina žice", "cordLength");
      }
      
      if($table === "clothing") {
        $code.= "
        <h3 class='mt-5'>Filteri</h3>
        <hr>";
        $size = ["S", "M", "L", "XL", "XXL"];
        $gender = ["Muški", "Ženski", "Uniseks"];
        $code.= $this->makeRadioButtons($size, $productData["size"], "Veličina", "clothingSize");
        $code.= $this->makeRadioButtons($gender, $productData["sex"], "Spol", "clothingSex");
      }

      if($table === "shoes") {
        $code.= "
        <h3 class='mt-5'>Filteri</h3>
        <hr>";
        $size = ["38","38.5","39","39.5", "40", "40.5", "41", "41.5", "42", "42.5", "43", "43.5", "44", "44.5", "45", "45.5", "46", "46.5", "47"];
        $gender = ["Muški", "Ženski", "Uniseks"];
        $code.= $this->makeRadioButtons($size, $productData["shoes_num"], "Veličina", "shoesSize");
        $code.= $this->makeRadioButtons($gender, $productData["sex"], "Spol", "shoesSex");
      }
      
      if($table === "balls") {
        $code.= "
        <h3 class='mt-5'>Filteri</h3>
        <hr>";
        $type = ["tennis" => ["Turnir", "Trening"], "badminton" => ["Najlon", "Perje"]];
        $speed = ["tennis" => [], "badminton" => ["Brze", "Brzina 3", "Srednje", "Spore"]];
        $code.= $this->makeRadioButtons($type[$productData["category"]], $productData["type"], "Tip loptice", "ballType");
        $code.= $this->makeRadioButtons($speed[$productData["category"]], $productData["speed"], "Brzina loptice", "ballSpeed");
      }
      echo $code;
    }

    public function changeProductData() {
      if($_SERVER["REQUEST_METHOD"] == "POST") {
        if(isset($_POST["submitChanges"])) {
          $counter = 0;
          $id = isset($_POST["ID"]) ? ["value" => +$_POST["ID"], "databaseKey" => "id", "jsonKey" => "ID"] : null;
          $name = isset($_POST["name"]) ? ["value" => $_POST["name"], "databaseKey" => "name", "jsonKey" => "name"] : null;
          $url = isset($_POST["img_url"]) ? ["value" => $_POST["img_url"], "databaseKey" => "img_url", "jsonKey" => "img_url"] : null;
          $price = isset($_POST["price"]) ? ["value" => $_POST["price"], "databaseKey" => "price", "jsonKey" => "price"] : null;
          $priceNoTax = isset($_POST["priceNoTax"]) ? ["value" => $_POST["priceNoTax"], "databaseKey" => "priceNOTAX", "jsonKey" => "priceNOTAX"] : null;
          $description = isset($_POST["description"]) ? ["value" => $_POST["description"], "databaseKey" => "description", "jsonKey" => "description"] : null;
          $category = isset($_POST["category"]) ? ["value" => $_POST["category"], "databaseKey" => "category", "jsonKey" => "category"] : null;
          $quantity = isset($_POST["quantity"]) ? ["value" => +$_POST["quantity"], "databaseKey" => "quantity", "jsonKey" => "quantity"] : null;
          $racketType = isset($_POST["racketType"]) ? ["value" => $_POST["racketType"], "databaseKey" => "racketType", "jsonKey" => "racketType"] : null;
          $racketWeight = isset($_POST["racketWeight"]) ? ["value" => $_POST["racketWeight"], "databaseKey" => "racketWeight", "jsonKey" => "racketWeight"] : null;
          $handlerSize = isset($_POST["handlerSize"]) ? ["value" => $_POST["handlerSize"], "databaseKey" => "handlerSize", "jsonKey" => "handlerSize"] : null;
          $bagSize = isset($_POST["bagSize"]) ? ["value" => $_POST["bagSize"], "databaseKey" => "size", "jsonKey" => "bagSize"] : null;
          $bagType = isset($_POST["bagType"]) ? ["value" => $_POST["bagType"], "databaseKey" => "type", "jsonKey" => "bagType"] : null;
          $cordThickness = isset($_POST["cordThickness"]) ? ["value" => $_POST["cordThickness"], "databaseKey" => "thicknesses", "jsonKey" => "cordThickness"] : null;
          $cordLength = isset($_POST["cordLength"]) ? ["value" => $_POST["cordLength"], "databaseKey" => "length", "jsonKey" => "cordLength"] : null;
          $clothingSize = isset($_POST["clothingSize"]) ? ["value" => $_POST["clothingSize"], "databaseKey" => "size", "jsonKey" => "clothingSize"] : null;
          $clothingGender = isset($_POST["clothingSex"]) ? ["value" => $_POST["clothingSex"], "databaseKey" => "sex", "jsonKey" => "clothingSex"] : null;
          $shoesSize = isset($_POST["shoesSize"]) ? ["value" => $_POST["shoesSize"], "databaseKey" => "shoes_num", "jsonKey" => "shoeSize"] : null;
          $shoesGender = isset($_POST["shoesSex"]) ? ["value" => $_POST["shoesSex"], "databaseKey" => "sex", "jsonKey" => "shoesSex"] : null;
          $ballType = isset($_POST["ballType"]) ? ["value" => $_POST["ballType"], "databaseKey" => "type", "jsonKey" => "ballType"] : null;
          $ballSpeed = isset($_POST["ballSpeed"]) ? ["value" => $_POST["ballSpeed"], "databaseKey" => "speed", "jsonKey" => "ballSpeed"] : null;
          $productCurrentData = $this->getDataFromEachProduct($id["value"]);
          $toChange = [$name,$url,$price,$priceNoTax,$description,$category,$quantity,$racketType,$racketWeight,$handlerSize,$bagSize,$bagType,$cordThickness,$cordLength,$clothingSize,
                        $clothingGender,$shoesSize,$shoesGender,$ballType,$ballSpeed];

          $jsonData = $this->getJson("./app/config/prijevod.json");
          
          $product = null;
          $category = null;
          foreach ($jsonData as $category => $eachArray) {
            foreach ($eachArray as $index => $value) {
              if($id["value"] === +$value["ID"]) {
                $product = &$jsonData[$category][$index];
              }
            }
          }

          foreach ($toChange as $key => $value) {
            if($value !== null && ($productCurrentData[$value["databaseKey"]] !== $value["value"])) {
              $table = $this->getProductTable($id["value"]);
              $sql = "UPDATE $table SET ".$value['databaseKey']." = ? WHERE id=?";
              $stmt = $this->conn->prepare($sql);
              $stmt->bind_param("ss", $value["value"] , $id["value"]);
              $stmt->execute();
              $product[$value["jsonKey"]] = $value["value"];
              $counter++;
            }
          }

          file_put_contents("./app/config/prijevod.json", json_encode($jsonData, JSON_PRETTY_PRINT));

          if($counter) {
            $_SESSION["message"]["type"] = "success";
            $_SESSION["message"]["text"] = "Uspješno ste promijenili podatke";
          }
        }
      }
    }
  }
?>