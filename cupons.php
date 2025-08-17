<?php
require_once("./php/inc/adminHeader.php");
  require_once("app/classes/dataInterface.php");

  $data = new Model($user);
  $user->relocate();
  $user->manageCupons();
?>


<div class="container my-5">
  <h1>Kuponi</h1>
  <hr>

  <div class="d-flex gap-3 mb-3">
    <?php $user->printAvailableCupons();?>
  </div>
  <form method="post">
    <div>
      <h3>Unesite novi kupon:</h3>
      <div class="mb-3">
        <input type="text" name="cuponName" class="form-control" placeholder="Unesite ime kupona"
         aria-label="cuponName" aria-describedby="basic-addon1">
      </div>
      <div class="input-group mb-3">
        <input type="number" class="form-control" placeholder="Unesite vrijednost kupona" 
        aria-label="cuponValue" aria-describedby="basic-addon1" name="cuponValue">
        <span class="input-group-text bg-success text-light" id="basic-addon1">%</span>
      </div>

      <input type="submit" value="Potvrdi" class="btn btn-success" name="addNewCupon">
    </div>
  </form>
</div>