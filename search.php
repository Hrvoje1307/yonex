<?php 
ob_start();
require_once("php/inc/header.php");
require_once("app/classes/User.php");
$user = new User();
$user->updateWishlist();
?>

<div class="container my-5">
    <h3 class="fw-bold">Rezultati pretraživanja</h3>
    <hr>
    <div class="d-flex gap-3 flex-wrap">
        <?php
            if(isset($_SESSION["search_result"])) {
                echo $_SESSION["search_result"];
                unset($_SESSION["search_result"]);  
            }else {
                echo "<div class='flex-grow-1 d-flex flex-column align-self-center justify-self-center align-items-center justify-content-center  my-5 py-5'>
                <i class='fs-2 bi bi-binoculars text-danger'></i>
                <h3 class='text-danger'>Nažalost nismo ništa pronašli</h3>
            </div>";
            }
        ?>
    </div>
</div>


<?php require_once("php/inc/footer.php");ob_end_flush();?>