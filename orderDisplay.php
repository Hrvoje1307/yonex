<?php
  require_once("./php/inc/adminHeader.php");
  require_once("app/classes/dataInterface.php");

  $data = new Model($user);
  $user->relocate();
  // $data->makeJson();
  $user->exportToExcel();
?>

<div class="container my-5">
  <div class="d-flex justify-content-between">
    <h1>Narudžbe</h1>
    <a href="exportToExcel.php"><button class="btn btn-success">Izvezi u excel</button></a>
  </div>
  <hr>

  <div class="testConatiner"></div>
  <?php ( $user->printAllOrders());?>
  

</div>