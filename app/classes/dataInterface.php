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
      $obj = $this->getJson("./app/config/products.json");
      $data = $obj["podjetje"]["izdelki"]["izdelek"];
      $products = array();
      foreach ($data as $key => $product) {
        array_push($products, [
          "position" => $key, 
          "id" => $product["izdelekID"],
          "name" => $product["izdelekIme"],
          "img" => isset($product["slikaVelika"]) ? $product["slikaVelika"] : null,
          "imgSmall" => isset($product["slikaMala"]) ? $product["slikaMala"] : null,
          "price" => $product["PPC"],
          "priceNOTAX" => $product["nabavnaCena"],
          "description" => $product["opis"],
          "category" => $product["kategorija"]["__cdata"],
          "quantity" => $product["tocnaZaloga"],
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
      $clothing = ["Nogavice", "Kratke hlače", "Majce", "Jakne", "Trenirke", "Obleke", "Ostalo-odijeća"];
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
  }
?>