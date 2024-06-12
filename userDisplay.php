<?php
  require_once("./php/inc/adminHeader.php");
  require_once("app/classes/dataInterface.php");

  $data = new Model($user);
  $user->relocate();
?>

<div class="container mt-5">
  <div class="table__height ">
    <table class="table table-striped table-hover">
      <thead class="table__head">
        <tr>
          <th>ID</th>
          <th>Ime</th>
          <th>Prezime</th>
          <th>Email</th>
          <th>Broj mobitela</th>
          <th>Admin</th>
        </tr>
      </thead>
      <tbody>
        <?php ($data->printUsers()); ?>
      </tbody>
    </table>
  </div>
</div>