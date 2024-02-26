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
   $password = $_POST['password'];
   

   $isLogged = $user->login($email, $password);

   if($isLogged) {
      $_SESSION['message']['type'] = 'success';
      $_SESSION['message']['text'] = 'Uspjesno ste se prijavili!'; 
      header("Location: index.php");
      exit();
   } else {
      $_SESSION['message']['type'] = 'danger';
      $_SESSION['message']['text'] = 'Neuspjesna prijava.'; // ovaj $_SESSION['message'] isprintas di oces gresku
   }
   
}


require_once("php/inc/header.php") ?>
  

   <div class="container-md height__container">
      <div class="row my-5">
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
                        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                     </div>
                     <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <input name="password" type="password" class="form-control" id="exampleInputPassword1">
                     </div>
                     <div class="mb-3">
                        <a href="#" class="fw-bolder text-secondary text-decoration-none">Zaboravili ste lozinku?</a>
                     </div>
                     <button type="submit" class="btn btn-dark">Submit</button>
                  </form>  
               </div>
            </div>
         </div>
      </div>
   </div>


   <?php require_once("php/inc/footer.php") ?>
         
</body>
</html>

