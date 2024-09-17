<?php
  require_once("app/classes/User.php");
  require_once("app/config/config.php");
  $user = new User();
  $user->afterSuccessfulCheckout();
  require_once("php/inc/header.php");
?>

<div class="container height__container d-flex justify-content-center align-items-center flex-column ">
  <i class="bi bi-check-circle h1 text-success"></i>
  <h1>Narudžba potvrđena</h1>
  <a href="index.php" class="btn btn-lg btn-success text-light mt-5">Nastavite kupovinu</a>
</div>

<?php
  require_once("php/inc/footer.php");

?>

