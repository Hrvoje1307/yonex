<?php require_once("./php/inc/header.php");
require_once("app/classes/User.php");
$user = new User();
$user->test();
if($_SESSION["name"]) {
    $user->changeData();
    $data = $user->fillData($_SESSION["user_id"]);
}

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
    <h1>Vaš korisnički račun</h1>
    <hr>
    <form method="POST">
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Ime</label>
            <input type="text" class="form-control" name="name" id="exampleFormControlInput1" value="<?php echo $data["name"]; ?>">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput2" class="form-label">Prezime</label>
            <input type="text" class="form-control" name="surname" id="exampleFormControlInput2" value="<?php echo $data["surname"]; ?>">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput3" class="form-label">Email</label>
            <input type="email" class="form-control" name="email" id="exampleFormControlInput3" value="<?php echo $data["email"]; ?>">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput4" class="form-label">Broj telefona</label>
            <input type="number" class="form-control" name="phone-number" id="exampleFormControlInput4" value="<?php echo $data["number"]; ?>">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput5" class="form-label">Stara lozinka <span class="text-danger">*</span></label>
            <div class="input-group">
               <input required type="password" name="old-password" id="exampleFormControlInput5" class="form-control password__form" placeholder="**********" aria-label="Input group example" aria-describedby="btnGroupAddon">
               <div class="input-group-text btn__password" id="btnGroupAddon"><i class="bi bi-eye-fill"></i></div>
            </div>
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput6" class="form-label">Nova lozinka</label>
            <div class="input-group">
               <input type="password" name="new-password" id="exampleFormControlInput6" class="form-control password__form" placeholder="**********" aria-label="Input group example" aria-describedby="btnGroupAddon">
               <div class="input-group-text btn__password" id="btnGroupAddon"><i class="bi bi-eye-fill"></i></div>
            </div>
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput7" class="form-label">Nova lozinka ponovoljena</label>
            <div class="input-group">
               <input required type="password" name="new-password-repeted" id="exampleFormControlInput5" class="form-control password__form" placeholder="**********" aria-label="Input group example" aria-describedby="btnGroupAddon">
               <div class="input-group-text btn__password" id="btnGroupAddon"><i class="bi bi-eye-fill"></i></div>
            </div>
        </div>
        <button class="btn btn-dark">Submit</button>
    </form>
</div>
<?php require_once("./php/inc/footer.php");?>