<?php
    require_once("./php/inc/header.php");
    require_once ("app/classes/User.php");
    $user = new User();
?>

<div class="container">
    <?php $user->singleProduct(); ?>
</div>

<?php
    require_once("./php/inc/footer.php");
?>