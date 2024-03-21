    <?php require_once("./php/inc/header.php");
    require_once("app/classes/User.php");
    $user = new User();
$user->getMail();
?>

<div class="container mb-5 mt-3 d-flex flex-column align-items-md-start align-items-center">
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
    <h1 class="fw-bolder">Zaboravljena lozinka</h1>
    <div class="mb-5 col-md-6 col-12">
        <form method="post">
            <label for="formGroupExampleInput" class="form-label">Unesite vaš email</label>
            <input type="email" name="email" class="form-control" id="formGroupExampleInput" placeholder="Vaš email">
            <button class="btn btn-dark mt-3">Nastaviti</button>
        </form>
    </div>
</div>

<?php require_once("./php/inc/footer.php");
?>