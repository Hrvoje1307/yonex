<?php
    require_once("./php/inc/header.php");
    require_once ("app/classes/User.php");
    $user = new User();
    $user->updateWishlist();
    $user->updateCart();
?>

<div class="container">
    <?php
        if(isset($_SESSION["message"]["type"])) {
        echo "
            <div class='mt-3 mb-0 alert alert-".$_SESSION["message"]["type"]."' role='alert'>
                ".$_SESSION['message']['text']."
            </div>
        ";
        unset($_SESSION["message"]["type"]);
        unset($_SESSION["message"]["message"]);
        }
    ?>
    <?php $user->singleProduct(); ?>
</div>

<?php
    require_once("./php/inc/footer.php");
?>