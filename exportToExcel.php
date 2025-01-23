<?php
  ob_start();

  require_once("app/config/config.php");
  require_once("app/classes/User.php");
  
  $user = new User();
  require_once("app/classes/dataInterface.php");
  $data = new Model($user);
  $user->relocate();
  $user->exportToExcel();
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
    <form method="post">
      <button type="submit" name="exportExcel" class="btn btn-success m-3">Izvezi</button>
    </form>
    
    <div class="conatiner">
      <table class='table'>
        <thead>
          <th>Order id</th>
          <th>Product id</th>
          <th>quantity</th>
          <th>Ime i prezime</th>
          <th>Email</th>
          <th>Broj mobitela</th>
          <th>Adresa</th>
          <th>Postcode</th>
          <th>Grad</th>
          <th>Poslano?</th>
        </thead>
        <tbody>
          <?php $user->printAllProductsFromCart(); ?>
        </tbody>
      </table>
    </div>
      
</body>

  