<?php
   require_once("./php/inc/adminHeader.php");
   require_once("app/classes/dataInterface.php");
 
   $data = new Model($user);
   $user->relocate();
   $product_id = isset($_GET["id"]) ? $_GET["id"] : null;
   $data->changeProductData();
?>

<div class="container my-5">
  <?php
      if(isset($_SESSION["message"]["type"])) {
        echo "
            <div class='mt-3 mb-3 alert alert-".$_SESSION["message"]["type"]."' role='alert'>
              ".$_SESSION['message']['text']."
            </div>
        ";
        unset($_SESSION["message"]["type"]);
        unset($_SESSION["message"]["text"]);
      }
  ?>
  <form method="post">
    <?php $data->printProductForm($product_id);?>
    <div class="d-flex justify-content-end">
      <button name="submitChanges" type="submit" class="btn btn-success align-self-start submit__btn">Promijeni</button>
    </div>
  </form>
</div>