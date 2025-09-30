<?php
  require_once("./php/inc/adminHeader.php");
  require_once("app/classes/dataInterface.php");

  $data = new Model($user);
  $user->relocate();

  $data->makeChangesXML();
?>

<div class="container my-5">
  <div class="d-flex justify-content-between">
    <h1>Izmjene u XML</h1>
    <form method="post">
      <button type="submit" name="removeXMLChanges" class="btn btn-primary">Izbrisi</button>
    </form>
  </div>
  <hr>
  
  <h3>Treba izbrisati</h3>
  <ul>
    <?php $data->printRemovedProducts();?>
  </ul>
  
</div>