<?php
   require_once("./php/inc/adminHeader.php");
   require_once("app/classes/dataInterface.php");
 
   $data = new Model($user);
   $user->relocate();
   $product_id = isset($_GET["id"]) ? $_GET["id"] : null;
   $data->changeProductData();
?>

<div class="container my-5">
  <div class="d-flex justify-content-end">
    <button type="button" class="btn btn-danger close__btn"><i class="bi bi-x-lg"></i></button>
  </div>
  <form method="post">
    <?php $data->printProductForm($product_id);?>
    <div class="d-flex justify-content-end">
      <button name="submitChanges" type="submit" class="btn btn-success align-self-start">Promijeni</button>
    </div>
  </form>
</div>