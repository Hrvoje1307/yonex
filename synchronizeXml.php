<?php
  require_once("./php/inc/adminHeader.php");
  require_once("app/classes/dataInterface.php");

  $data = new Model($user);
  $user->relocate();

  $data->callTrainslationFunctions();
?>

<div class="container my-5">
  <div class="d-flex justify-content-between">
    <h1>Izmjene u XML</h1>
    <form method="post">
      <button type="submit" name="submitXMLChanges" class="btn btn-primary">Promijeni</button>
    </form>
  </div>
  <hr>
  
  <h3>Treba promijeniti</h3>
  <ul>
    <?php   $data->compareProducts();?>
  </ul>
  
</div>