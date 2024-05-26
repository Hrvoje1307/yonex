<?php
require_once("./php/inc/header.php");
require_once("app/classes/User.php");
$user = new User();
$user->tokenPassword();
echo $user->changePassword();
?>

<div class="container d-flex flex-column align-items-sm-start align-items-center my-3">
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
    <h1 class="fw-bolder">Promijeni lozinku</h1>
    <div class="col-sm-6 col-12 ">
        <form method="post">
            <div class="mb-3 col-12">
                <label for="new_password" class="form-label">Nova lozinka</label>
                <input type="password" class="form-control" name="new_password" id="new_password" placeholder="********">
            </div>
            <div class="mb-3 col-12">
                <label for="new_password_repeated" class="form-label">Nova lozinka ponovljena</label>
                <input type="password" class="form-control" name="new_password_repeated" id="new_password_repeated" placeholder="********">
            </div>
            <button class="btn btn-dark">Potvrdi</button>
        </form>
    </div>
</div>

<?php require_once("./php/inc/header.php");?>