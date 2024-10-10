<?php
require_once("app/config/config.php");
require_once("app/classes/User.php");
$user = new User();

if($user->is_logged()) {
   header("Location: index.php");
   exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   $email = $_POST['email'];
   var_dump($_POST["password"]);
   $password = $_POST['password'];
   

   $isLogged = $user->login($email, $password);

   if($isLogged === "admin") {
      header("Location: dataDisplay.php?page=1");
      exit();
   } else if($isLogged) {
      header("Location: index.php");
      exit();
   }else {
      $_SESSION['message']['type'] = 'danger';
      $_SESSION['message']['text'] = 'Krivi email ili lozinka'; // ovaj $_SESSION['message'] isprintas di oces gresku
   }
   
}


require_once("php/inc/header.php") ?>
  

   <div class="container-md height__container">
      <?php
         if(isset($_SESSION["message"]["type"])) {
            echo "
               <div class='mt-3 mb-0 alert alert-".$_SESSION["message"]["type"]."' role='alert'>
                  ".$_SESSION['message']['text']."
               </div>
            ";
            unset($_SESSION["message"]["type"]);
            unset($_SESSION["message"]["message"]);
         }
      ?>
      <div class="row my-5 mt-3">
         <div class="col-md-6 col-12">
            <div class="card">
               <div class="card-body bg-lightwhite shadow-sm">
                  <h5 class="card-title fs-2 fw-bold">Novi korisnik</h5>
                  <h6 class="fw-bolder text-secondary">Registracija novog korisnika</h6>
                  <p class="card-text">Registracijom u našu internet trgovinu moći ćete kupovati, pratiti status i povijest svojih narudžbi, primati e-novosti po želji te ostvariti sve ostale pogodnosti i promocije za naše korisnike. Kliknite na gumb "Nastavi"</p>
                  <a href="registration.php" class="btn btn-dark text-light">Nastaviti</a>
               </div>
            </div>
         </div>
         <div class="col-md-6 col-12 my-md-0 my-3">
            <div class="card">
               <div class="card-body bg-lightwhite shadow-sm">
                  <h5 class="card-title fs-2 fw-bold">Postojeći korisnik</h5>
                  <h6 class="fw-bolder text-secondary">Već imam račun:</h6>
                  <form method="POST">
                     <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email address</label>
                        <input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                        <div id="emailHelp" class="form-text">Mi nećemo nikad dijeliti vaš email sa nikim.</div>
                     </div>
                     <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <div class="input-group">
                           <input name="password" type="password" class="form-control password__form" aria-label="Input group example" aria-describedby="btnGroupAddon">
                           <div class="input-group-text btn__password" id="btnGroupAddon"><i class="bi bi-eye-fill"></i></div>
                        </div>
                     </div>
                     <div class="mb-3">
                        <a href="forgotten-password.php" class="fw-bolder text-secondary text-decoration-none">Zaboravili ste lozinku?</a>
                     </div>
                     <button type="submit" class="btn btn-dark">Nataviti</button>
                  </form>  
               </div>
            </div>
         </div>
      </div>
   </div>


   <?php require_once("php/inc/footer.php") ?>
         
</body>
</html>

