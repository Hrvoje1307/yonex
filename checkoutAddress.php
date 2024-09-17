<?php
  require_once("./php/inc/header.php");
  require_once("app/classes/dataInterface.php");
  require_once("app/classes/User.php");

  $user = new User();
  $data = new Model($user);
  $userId = $_SESSION["user_id"];

  $user->submitAddressCheckout();
?>

<div class="container my-5">
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
  <h1>Adresa za dostavu</h1>
  <hr>
  <form method="post">
    <div class="mb-3">
      <label for="fullName" class="form-label">Puno ime i prezime <span class="text-danger">*</span></label>
      <input require type="text" class="form-control" id="fullName" name="fullName" placeholder="Ivan Horvat" value="<?php echo $user->fillData($userId)["name"]; echo " ".$user->fillData($userId)["surname"];?>">
    </div>
    <div class="mb-3">
      <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
      <input require type="email" class="form-control" id="email" name="email" placeholder="ivanhorvat@gmail.com" value="<?php echo $user->fillData($userId)["email"]; ?>">
    </div>
    <div class="mb-3">
      <label for="phoneNumber" class="form-label">Broj mobitela <span class="text-danger">*</span></label>
      <input require type="text" class="form-control" id="phoneNumber" name="phoneNumber" placeholder="+38512345689" value="<?php echo $user->fillData($userId)["number"]; ?>">
      <div id="phoneNumberHelp" class="form-text">Može se koristiti kao pomoć pri isporuci.</div>
    </div>
    <div class="mb-3">
      <label for="address" class="form-label">Adresa <span class="text-danger">*</span></label>
      <input require type="text" class="form-control" name="address" id="address" placeholder="Ulica Ivana Kukuljevića 17" value="<?php echo $user->fillData($userId)["address"]; ?>">
    </div>
    <div class="mb-3 d-flex gap-3">
      <div>
        <label for="postcode" class="form-label">Poštanski broj <span class="text-danger">*</span></label>
        <input require type="text" class="form-control" name="postcode" id="postcode" placeholder="10000" value="<?php echo $user->fillData($userId)["postcode"]; ?>">
      </div>
      <div>
        <label for="town" class="form-label">Grad <span class="text-danger">*</span></label>
        <input require type="text" class="form-control" id="town" name="town" placeholder="Zagreb" value="<?php echo $user->fillData($userId)["town"]; ?>">
      </div>
    </div>
    <div class="mb-3">
      <input type="checkbox" class="form-check-input" name="saveAddress" id="saveAddress">
      <label class="form-check-label" for="saveAddress">Spremi adresu</label>
    </div>
    <button type="submit" name="submitAddressCheckout" class="btn btn-dark">Provjera</button>
  </form>
</div>
