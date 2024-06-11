<?php 
ob_start();

require_once("app/config/config.php");
require_once("app/classes/User.php");

$user = new User();
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
   <script type="module" defer src="js/controller/dataController.js"></script>

   <title>Data</title>
</head>

<body>
   <div class="container-fluid bg-primary">
   <div class="d-flex justify-content-center p-2">
      <form action="index.php" method="post">
         <button type="submit" class="btn btn-primary border border-rounded">Korisnik</button>
      </form>
   </div>
   </div>

   <nav class="navbar navbar-expand-lg bg-body-tertiary">
      <div class="container-fluid">
         <a class="navbar-brand" href="#">Admin panel</a>
         <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
         </button>
         <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
               <a class="nav-link active" aria-current="page" href="dataDisplay.php">Proizvodi</a>
            </li>
            <li class="nav-item">
               <a class="nav-link active" aria-current="page" href="userDisplay.php">Korisnici</a>
            </li>
            <li class="nav-item">
               <a class="nav-link active" aria-current="page" href="orderDisplay.php">Narudžbe</a>
            </li>
            <div class="dropdown mb-0 d-flex ms-3">
               <button class="btn p-0 dropdown-toggle d-flex gap-2 align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <?php if($user->is_logged()) : ?>
                     <p class="my-0 d-none d-md-block text-secondary"><?php echo $_SESSION["name"];?></p>
                  <?php else :?>
                     <p class="my-0 d-none d-md-block text-secondary">Moj račun</p>
                  <?php endif ;?>
               </button>
               
               <ul class="dropdown-menu">
                  <?php if ($user->is_logged()) : ?>
                     <li><a class="dropdown-item" href="logout.php">Odjava</a></li> 
                  <?php else : ?>
                        <li><a class="dropdown-item" href="login.php">Prijava</a></li>
                        <li><a class="dropdown-item" href="registration.php">Registracija</a></li>
                  <?php endif; ?>
               </ul>
            </div>
            </ul>
         </div>
      </div>
   </nav>