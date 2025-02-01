<?php
  require_once("./php/inc/adminHeader.php");
  require_once("app/classes/dataInterface.php");

  $data = new Model($user);
  $user->relocate();
?>

<div class="container my-5">
  <h1>Torbe</h1>
  <table class="table">
  <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">ID</th>
        <th scope="col">Ime</th>
        <th scope="col">Slika</th>
        <th scope="col">Cijena</th>
        <th scope="col">Nabavna cijena</th>
        <th scope="col">Opis</th>
        <th scope="col">Kategorija</th>
        <th scope="col">Količina</th>
      </tr>
    </thead>
    <tbody class="table__body__bags"></tbody>
  </table>
  <div class="pages__btns"></div>
</div>