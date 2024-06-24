<?php
  require_once("./php/inc/adminHeader.php");
  require_once("app/classes/dataInterface.php");

  $data = new Model($user);

  $user->relocate();

  $id = isset($_GET["data"]) ? $_GET["data"] : null;
  $is_admin = $user->fillData($id)["is_admin"];

  $data->changeUserSettings();
?>

<div class="container my-5 d-flex flex-column">
  <button type="button" class="btn btn-danger align-self-end close__btn"><i class="bi bi-x-lg"></i></button>
  <?php
    if(isset($_SESSION["message"]["type"])) {
      echo "
          <div class='my-3 alert alert-".$_SESSION["message"]["type"]."' role='alert'>
            ".$_SESSION['message']['text']."
          </div>
      ";
      unset($_SESSION["message"]["type"]);
      unset($_SESSION["message"]["text"]);
    }
  ?>
  <h1>Korisnicki račun</h1>
  <form method="post">
    <div class="mb-3">
      <label for="nameExample" class="form-label">Ime</label>
      <input type="text" class="form-control" name="name" id="nameExample" aria-describedby="emailHelp" value ="<?php echo $user->fillData($id)["name"];?>">
    </div>
    <div class="mb-3">
      <label for="surnameExample" class="form-label">Prezime</label>
      <input type="text" class="form-control" name="surname" id="surnameExample" aria-describedby="emailHelp" value ="<?php echo $user->fillData($id)["surname"];?>">
    </div>
    <div class="mb-3">
      <label for="emailExample" class="form-label">Email</label>
      <input type="email" class="form-control" name="email" id="emailExample" aria-describedby="emailHelp" value ="<?php echo $user->fillData($id)["email"];?>">
    </div>
    <div class="mb-3">
      <label for="numberExample" class="form-label">Broj mobitela</label>
      <input type="number" class="form-control" name="number" id="numberExample" aria-describedby="emailHelp" value ="<?php echo $user->fillData($id)["number"];?>">
    </div>
    <div class="mb-3 form-check">
      <input type="radio" class="form-check-input" name="userType" id="adminCheck" value="1" <?php echo $is_admin == 1 ? "checked" : null ?>>
      <label class="form-check-label" for="adminCheck">Admin</label>
    </div>
    <div class="mb-3 form-check">
      <input type="radio" class="form-check-input" name="userType" id="customerCheck" value="0" <?php echo $is_admin == 0 ? "checked" : null ?>>
      <label class="form-check-label" for="customerCheck">Korisnik</label>
    </div>
    <button type="submit" name="submit" class="btn btn-primary">Potvrdi</button>
  </form>
  <hr class="my-5">
  <h1>Narudžbe</h1>
  <div class="row ">
    <p class="d-flex justify-content-center align-items-center">Trenutno nemate niti jednu narudžbu</p>
  </div>
</div>