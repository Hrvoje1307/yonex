<?php
  ob_start();
  require_once("app/classes/User.php");
  require_once("app/config/config.php");
  $user = new User();
  if($user->is_logged()) {
    require_once("php/inc/header.php");
    $user->updateCart();
    $user->submitCheckout();
    require_once("cart-content.php");
    
    require_once("php/inc/footer.php");
    ob_end_flush();
  } else {
    header("Location: login.php");
    exit();
  }
?>
</body>
</html>
