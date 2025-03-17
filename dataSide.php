<?php
  require_once("./php/inc/adminHeader.php");
  require_once("app/classes/dataInterface.php");

  $data = new Model($user);
  $user->relocate();

?>

<div class="container my-5">
  <div class="d-flex justify-content-between">
    <h1>Izmjene u XML</h1>
    <button class="btn btn-primary">Promijeni</button>
  </div>
  <hr>

  <h3>Treba dodati</h3>
  <ul>
    <?php  $data->addProducts(); ?>
  </ul>

  <hr>
  
  <h3>Treba izbrisati</h3>
  <ul>
    <?php $data->removeProducts();?>
  </ul>
  
  <hr>
  
  <h3>Treba promijeniti</h3>
  <ul>
    <?php $data->compareProducts();?>
  </ul>
  
</div>