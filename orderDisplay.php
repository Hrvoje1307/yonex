<?php
  require_once("./php/inc/adminHeader.php");
  require_once("app/classes/dataInterface.php");

  $data = new Model($user);
  $user->relocate();
?>

<div class="container my-5">
  <h1>Narudžbe</h1>
  <hr>

  <?php ( $user->printAllOrders());?>

  <!-- <div class="alert alert-danger" role="alert">
    <a href="#" class='d-flex justify-content-between'>
          <div>
              <h5 >Broj Narudžbe</h5>
              <p >Text</p>
          </div>
          <div>
              <h4>Ukupna cijena: 200 €</h4>
              <p><b>Korisnik</b>: Hrvoje Čučković</p>
          </div>
    </a>
  </div>

  <div class="alert alert-success" role="alert">
    <a href="#" class='d-flex justify-content-between'>
          <div>
              <h5 >Broj Narudžbe</h5>
              <p >Text</p>
          </div>
          <div>
              <h4>Ukupna cijena: 200 €</h4>
              <p><b>Korisnik</b>: Hrvoje Čučković</p>
          </div>
    </a>
  </div> -->
</div>