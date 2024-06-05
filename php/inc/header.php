<?php 
ob_start();

require_once("app/config/config.php");
require_once("app/classes/User.php");
$user = new User();

$user -> searchResults();
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="icon" type="image/x-icon" href="./images/brand/favicon.jpg">
   <!-- BOOTSRAP -->
   <link rel="stylesheet" href="./css/style.css">
   <link rel="stylesheet" href="./css/my-style.css">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
   <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
   <script type="module" defer src="js/controller/incController.js"></script>

   <title>Yonex</title>
</head>
<body>
<div class="container-lg">
   <div class="row my-3">
      <div class="col-12 d-flex gap-2 justify-content-end">
         <a href="tel:+385957056320" class="d-flex align-items-center gap-2 text-decoration-none text-secondary">
            <i class="bi bi-telephone-fill text-secondary"></i>
            <p class="my-0 d-none d-md-block">+385957056320</p>
         </a>
         <div class="d-flex align-items-center gap-2">
            <div class="dropdown">
               <button class="btn p-0 dropdown-toggle d-flex gap-2 align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="bi bi-person-fill text-secondary"></i>
                  <?php if($user->is_logged()) : ?>
                     <p class="my-0 d-none d-md-block text-secondary"><?php echo $_SESSION["name"];?></p>
                  <?php else :?>
                     <p class="my-0 d-none d-md-block text-secondary">Moj račun</p>
                  <?php endif ;?>
               </button>
               
               <ul class="dropdown-menu">
                  <?php if ($user->is_logged()) : ?>
                     <li><a class="dropdown-item" href="account.php">Korisnički račun</a></li> 
                     <li><a class="dropdown-item" href="logout.php">Odjava</a></li> 
                  <?php else : ?>
                        <li><a class="dropdown-item" href="login.php">Prijava</a></li>
                        <li><a class="dropdown-item" href="registration.php">Registracija</a></li>
                  <?php endif; ?>
               </ul>
            </div>
         </div>
         <a href="wishlist.php" class="d-flex align-items-center gap-2 text-decoration-none text-secondary">
            <i class="bi bi-heart-fill text-secondary"></i>
            <p class="my-0 d-none d-md-block">Lista želja (<span class="header__wishlish-quantity"><?php echo $user->getWishlistData()[1]?></span>)</p>
         </a>
         <a href="cart.php" class="d-flex align-items-center gap-2 text-decoration-none text-secondary">
            <i class="bi bi-cart-fill text-secondary"></i>
            <p class="my-0 d-none d-md-block">Košarica</p>
         </a>
      </div>
   </div>
</div>
<nav class="navbar navbar-expand-lg">
   <div class="container-lg">
      <a class="navbar-brand" href="./index.php">
         <img src="./images/brand/logo.png" alt="Main logo">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
         <span class="navbar-toggler-icon"></span>
      </button>
      <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
         <div class="offcanvas-header">
            <div class="row justify-content-end">
               <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
         </div>
         <div class="offcanvas-body justify-content-between">
            <ul class="navbar-nav mx-xxl-5 mg-lg-1">
               <li class="nav-item dropdown my-dropdown">
                  <p class="nav-link my-0 text-uppercase fw-bold my-nav-link" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                     Tenis
                  </p>
                  <ul class="dropdown-menu my-dropdown-menu row">
                     <div class="col d-lg-flex">
                        <li><a class="dropdown-item" href="vibration-damper.php?page=1">
                           <img class="nav__product-img d-none d-lg-block" src="./images/product-images/tennis/vibration__dampers.webp" alt="Product image">
                           <p class="my-0 text-lg-center text-wrap">Prigušivaći vibracije</p>
                        </a></li>
                        <li><a class="dropdown-item" href="tennis-rackets.php?page=1">
                           <img class="nav__product-img d-none d-lg-block" src="./images/product-images/tennis/racket.webp" alt="Product image">
                           <p class="my-0 text-lg-center text-wrap">Reketi</p>
                        </a></li>
                        <li><a class="dropdown-item" href="tennis-shoes.php?page=1">
                           <img class="nav__product-img d-none d-lg-block" src="./images/product-images/tennis/shoes.webp" alt="Product image">
                           <p class="my-0 text-lg-center text-wrap">Obuća</p>
                        </a></li>
                        <li><a class="dropdown-item" href="tennis-cords.php?page=1">
                           <img class="nav__product-img d-none d-lg-block" src="./images/product-images/tennis/string.webp" alt="Product image">
                           <p class="my-0 text-lg-center text-wrap">Žice</p>
                        </a></li>
                     </div>
                     <div class="col d-lg-flex">
                        <li><a class="dropdown-item" href="tennis-balls.php?page=1">
                           <img class="nav__product-img d-none d-lg-block" src="./images/product-images/tennis/balls.webp" alt="Product image">
                           <p class="my-0 text-lg-center text-wrap">Loptice</p>
                        </a></li>
                        <li><a class="dropdown-item" href="https://issuu.com/yonex-ger/docs/yonex_tennis_katalog_2023_en">
                           <img class="nav__product-img d-none d-lg-block" src="./images/product-images/tennis/tennis__catalog.webp" alt="Product image">
                           <p class="my-0 text-lg-center text-wrap">Katalog</p>
                        </a></li>
                     </div>
                  </ul>
               </li>
               <li class="nav-item dropdown my-dropdown">
                  <p class="nav-link my-0 text-uppercase fw-bold my-nav-link" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                     Badminton
                  </p>
                  <ul class="dropdown-menu my-dropdown-menu row">
                     <div class="col d-lg-flex">
                        <li><a class="dropdown-item" href="badminton-rackets.php?page=1" ?>
                           <img class="nav__product-img d-none d-lg-block" src="./images/product-images/badminton/recket.webp" alt="Product image">
                           <p class="my-0 text-lg-center text-wrap">Reketi</p>
                        </a></li>
                        <li><a class="dropdown-item" href="badminton-shoes.php?page=1">
                           <img class="nav__product-img d-none d-lg-block" src="./images/product-images/badminton/shoes.webp" alt="Product image">
                           <p class="my-0 text-lg-center text-wrap">Obuća</p>
                        </a></li>
                        <li><a class="dropdown-item" href="badminton-cords.php?page=1">
                           <img class="nav__product-img d-none d-lg-block" src="./images/product-images/badminton/cords.webp" alt="Product image">
                           <p class="my-0 text-lg-center text-wrap">Žice</p>
                        </a></li>
                        <li><a class="dropdown-item" href="badminton-balls.php?page=1">
                           <img class="nav__product-img d-none d-lg-block" src="./images/product-images/badminton/balls.webp" alt="Product image">
                           <p class="my-0 text-lg-center text-wrap">Loptice</p>
                        </a></li>
                     </div>
                     <div class="col d-lg-flex">
                        <li><a class="dropdown-item" href="https://issuu.com/yonex-ger/docs/yonex_badminton_katalog_2023_en">
                           <img class="nav__product-img d-none d-lg-block" src="./images/product-images/badminton/catalog.webp" alt="Product image">
                           <p class="my-0 text-lg-center text-wrap">Katalog</p>
                        </a></li>
                     </div>
                  </ul>
               </li>
               <li class="nav-item dropdown my-dropdown">
                  <p class="nav-link my-0 text-uppercase fw-bold my-nav-link" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                     Torbe
                  </p>
                  <ul class="dropdown-menu my-dropdown-menu">
                     <li><a class="dropdown-item" href="rucksacks.php?page=1">
                        <img class="nav__product-img d-none d-lg-block" src="./images/product-images/bags/rucksack.jpeg" alt="Product image">
                        <p class="my-0 text-lg-center text-wrap">Ruksaci</p>
                     </a></li>
                     <li><a class="dropdown-item" href="bags.php?page=1">
                        <img class="nav__product-img d-none d-lg-block" src="./images/product-images/bags/bags.jpeg" alt="Product image">
                        <p class="my-0 text-lg-center text-wrap">Torbe</p>
                     </a></li>
                  </ul>
               </li>
               <li class="nav-item dropdown my-dropdown">
                  <p class="nav-link my-0 text-uppercase fw-bold my-nav-link " role="button" data-bs-toggle="dropdown" aria-expanded="false">
                     Odijeća
                  </p>
                  <ul class="dropdown-menu my-dropdown-menu row special__dropdown">
                     <div class="col d-lg-flex">
                        <li><a class="dropdown-item" href="jackets.php?page=1">
                           <img class="nav__product-img d-none d-lg-block" src="./images/product-images/clothing/jackets.jpeg" alt="Product image">
                           <p class="my-0 text-lg-center text-wrap">Jakne</p>
                        </a></li>
                        <li><a class="dropdown-item" href="shorts.php?page=1">
                           <img class="nav__product-img d-none d-lg-block" src="./images/product-images/clothing/shorts.webp" alt="Product image">
                           <p class="my-0 text-lg-center text-wrap">Kratke hlače</p>
                        </a></li>
                        <li><a class="dropdown-item" href="t-shirts.php?page=1">
                           <img class="nav__product-img d-none d-lg-block" src="./images/product-images/clothing/t-shirts.webp" alt="Product image">
                           <p class="my-0 text-lg-center text-wrap">Majce kratkih rukava</p>
                        </a></li>
                        <li><a class="dropdown-item" href="socks.php?page=1">
                           <img class="nav__product-img d-none d-lg-block" src="./images/product-images/clothing/socks.webp" alt="Product image">
                           <p class="my-0 text-lg-center text-wrap">Čarape</p>
                        </a></li>
                     </div>
                     <div class="col d-lg-flex">
                        <li><a class="dropdown-item" href="dress.php?page=1">
                           <img class="nav__product-img d-none d-lg-block" src="./images/product-images/clothing/dress.webp" alt="Product image">
                           <p class="my-0 text-lg-center text-wrap">Haljine</p>
                        </a></li>
                        <li><a class="dropdown-item" href="rest-clothing.php?page=1">
                           <img class="nav__product-img d-none d-lg-block" src="./images/product-images/clothing/rest.webp" alt="Product image">
                           <p class="my-0 text-lg-center text-wrap">Ostalo</p>
                        </a></li>
                        <li><a class="dropdown-item" href="pants.php?page=1">
                           <img class="nav__product-img d-none d-lg-block" src="./images/product-images/clothing/pants.webp" alt="Product image">
                           <p class="my-0 text-lg-center text-wrap">Trenirke</p>
                        </a></li>
                        <li><a class="dropdown-item" href="https://issuu.com/yonex-ger/docs/yonex_bekleidungskatalog_2023">
                           <img class="nav__product-img d-none d-lg-block" src="./images/product-images/clothing/catalog.webp" alt="Product image">
                           <p class="my-0 text-lg-center text-wrap">Katalog</p>
                        </a></li>
                     </div>
                  </ul>
               </li>
               <li class="nav-item dropdown my-dropdown">
                  <p class="nav-link my-0 text-uppercase fw-bold my-nav-link" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                     Dodatci
                  </p>
                  <ul class="dropdown-menu my-dropdown-menu special__dropdown">
                     <li><a class="dropdown-item" href="towels.php?page=1">
                        <img class="nav__product-img d-none d-lg-block" src="./images/product-images/accessories/towels.webp" alt="Product image">
                        <p class="my-0 text-lg-center text-wrap">Ručnici</p>
                     </a></li>
                     <li><a class="dropdown-item" href="gums.php?page=1">
                        <img class="nav__product-img d-none d-lg-block" src="./images/product-images/accessories/gum.webp" alt="Product image">
                        <p class="my-0 text-lg-center text-wrap">Gume</p>
                     </a></li>
                     <li><a class="dropdown-item" href="rest.php?page=1">
                        <img class="nav__product-img d-none d-lg-block" src="./images/product-images/accessories/rest.webp" alt="Product image">
                        <p class="my-0 text-lg-center text-wrap">Ostatak</p>
                     </a></li>
                     <li><a class="dropdown-item" href="tints.php?page=1">
                        <img class="nav__product-img d-none d-lg-block" src="./images/product-images/accessories/stencils.webp" alt="Product image">
                        <p class="my-0 text-lg-center text-wrap">Šablone i tinte</p>
                     </a></li>
                     <li><a class="dropdown-item" href="sweats.php?page=1">
                        <img class="nav__product-img d-none d-lg-block" src="./images/product-images/accessories/sweatpants.webp" alt="Product image">
                        <p class="my-0 text-lg-center text-wrap">Znojnici</p>
                     </a></li>
                  </ul>
               </li>
            </ul>
            <form method="POST" class="mx-xxl-5 mx-lg-1 my-3 my-lg-0 mb-lg-0">
               <div class="input-group  border border-1 rounded flex-nowrap">
                  <input type="text" name="search-input" class="form-control border border-0" placeholder="Search..." aria-label="Search" aria-describedby="addon-wrapping">
                  <button name="submit-search" class="input-group-text border border-0 bg-light" id="addon-wrapping">
                     <i class="bi bi-search"></i>
                  </button>
               </div>
            </form>
            <a href="cart.php" class="btn btn-dark d-flex gap-1 text-light">
               <i class="bi bi-cart-fill"></i>
               <span class="product-number">0</span> 
            </a>
         </div>
      </div>
   </div>
</nav>