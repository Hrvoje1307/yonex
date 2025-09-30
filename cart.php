<?php
  ob_start();
  require_once("app/classes/User.php");
  require_once("app/config/config.php");
  $user = new User();
  // isset($_COOKIE["cart"]) ? var_dump($_COOKIE["cart"]) : var_dump( "nema") ;
  require_once("php/inc/header.php");
  $user->updateCart();
  $user->submitCheckout();
  require_once("cart-content.php");
  
  require_once("php/inc/footer.php");
  ob_end_flush();
  
?>
</body>
</html>
