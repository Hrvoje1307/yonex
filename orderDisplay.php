<?php
  require_once("./php/inc/adminHeader.php");
  require_once("app/classes/dataInterface.php");

  $data = new Model($user);
  $user->relocate();
  var_dump($data->getProducts()[64]);
?>

<div class="container my-5">
  <h1>Narudžbe</h1>
  <hr>

  <div class="testConatiner"></div>
  <?php ( $user->printAllOrders());?>

</div>