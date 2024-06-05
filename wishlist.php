<?php
  require_once("app/classes/User.php");
  require_once("app/config/config.php");
  $user = new User();
  if($user->is_logged()) {
    require_once("php/inc/header.php");
    $user->updateWishlist();
    $user->updateCart();
    require_once("wishlist-content.php");
    require_once("php/inc/footer.php");
  } else {
    header("Location: login.php");
  }
?>
</body>
</html>
