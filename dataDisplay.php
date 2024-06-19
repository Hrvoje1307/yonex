<?php
  require_once("./php/inc/adminHeader.php");
  require_once("app/classes/dataInterface.php");

  $data = new Model($user);
  $user->relocate();
  $data->changePageNumber();
?>

<div class="container mt-5">
  <pre><?php 
  // $data->aiTranslation($data->makeJson());
  $data->productsTranslated();
  ?></pre>
  <div class="table__height ">
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
          <th>Količina</th>
        </tr>
      </thead>
      <tbody>
        <?php ($data->printProducts()); ?>
      </tbody>
    </table>
  </div>
  <div>
    <form method="post">
      <?php $data->printPagesButtons(); ?>
    </form>
  </div>
</div>