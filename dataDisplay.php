<?php
  require_once("./php/inc/dataHeader.php");
  require_once("app/classes/dataInterface.php");

  $data = new Model();
?>

<div class="container">
  <h1 class="mb-5">Data</h1>
  <div class="table__height">
    <table class="table table-striped table-hover">
      <thead class="table__head">
        <tr>
          <th>Pozicija</th>
          <th>ID</th>
          <th>Ime</th>
          <th>Slika</th>
          <th>Cijena</th>
          <th>Nabavna cijena</th>
          <th>Opis</th>
          <th>Kategorija</th>
        </tr>
      </thead>
      <tbody>
        <?php ($data->printProducts()); ?>
      </tbody>
    </table>
  </div>
  <!-- <pre ><?php ($data->printIDs()); ?></pre> -->
</div>