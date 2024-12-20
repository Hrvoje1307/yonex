<?php 

require_once ("app/config/config.php");
require_once ("app/classes/User.php");

$user = new User();

if($user->is_logged()) {
   header("Location: index.php");
   exit();
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   unset($_SESSION['message']['type']);
   unset($_SESSION['message']['text']);
   $name = $_POST['name'];
   $surname = $_POST['surname'];
   $email = $_POST['email'];
   $number = $_POST['number'];
   $password = $_POST['password'];
   $r_password = $_POST['r_password'];
   
   $isNumberExists = $user->numberExists($number);
   $isEmailExists = $user->emailExists($email);
   
   if (isset($name) || isset($surname) || isset($email) || isset($number) || isset($password) || isset($r_password)) {
      if (isset($_POST['checker'])) {
            if ($isNumberExists) {
               $_SESSION['message']['type'] = 'danger';
               $_SESSION['message']['text'] = 'Ovaj broj vec postoji.';
            } else if ($isEmailExists) {
               $_SESSION['message']['type'] = 'danger';
               $_SESSION['message']['text'] = 'Ovaj e-mail vec postoji.';
            } else {
               if ($password === $r_password) {
                  if($user->passwordCheck($password)) {
                     $created = $user->create($name, $surname, $email, $number, $password);
                     if ($created) {
                        $_SESSION['message']['type'] = 'success';
                        $_SESSION['message']['text'] = 'Uspiješno ste se registrirali.';
                        header("Location: login.php");
                        exit();
                     }
                  } else {
                     $_SESSION['message']['type'] = 'danger';
                     $_SESSION['message']['text'] = 'Lozinka mora sadržavati veliko slovo, malo slovo, broj, specijalni znak i mora biti duza od 9 znakova';
                  }
               } else {
                  $_SESSION['message']['type'] = 'danger';
                  $_SESSION['message']['text'] = 'Lozinke su razlicite.';
               }
            }
      } else {
         $_SESSION['message']['type'] = 'danger';
         $_SESSION['message']['text']  = 'Morate prihvatiti uvjete koristenja.';
      }
   } else {
      $_SESSION['message']['type'] = 'danger';
      $_SESSION['message']['text'] = 'Sva polja OBAVEZNO moraju biti popunjena.';
   }
   
}

require_once("php/inc/header.php") ?>
  

   <div class="container-md py-5 height__container">
      <h2 class="text-dark fw-bolder fs-1">Registracija</h2>
      <a href="login.php" class="text-dark text-decoration-none">Imate račun? <u>Prijavite se</u></a>
      <?php
         if(isset($_SESSION["message"]["type"]) && $_SESSION["message"]["type"] == "danger") {
            echo "
               <div class='mt-3 alert alert-".$_SESSION["message"]["type"]."' role='alert'>
                  ".$_SESSION['message']['text']."
               </div>
            ";
            unset($_SESSION["message"]["type"]);
            unset($_SESSION["message"]["message"]);
         }
      ?>
      <form method="POST" class="my-2">
         <p class="text-dark fw-semibold fs-5 m-0">Osobni podaci</p>
         <hr class="line__footer bg-dark m-0">

         <div class="my-3 ms-sm-5 ms-0  d-flex align-items-center justify-content-between gap-3">
            <label for="name" class="form-label form__label m-0 fw-semibold"><span class="text-danger">*</span>Ime</label>
            <input name="name" type="text" class="form-control" id="name" placeholder="Vaše ime">
         </div>
         <div class="my-3 ms-sm-5 ms-0 d-flex align-items-center justify-content-between gap-3">
            <label for="surname" class="form-label form__label m-0 fw-semibold"><span class="text-danger">*</span>Prezime</label>
            <input name="surname" type="text" class="form-control" id="surname" placeholder="Vaše prezime">
         </div>
         <div class="my-3 ms-sm-5 ms-0 d-flex align-items-center gap-3">
            <label for="email" class="form-label form__label m-0 fw-semibold"><span class="text-danger">*</span>Email adresa</label>
            <input name="email" type="email" class="form-control" id="email" placeholder="Vaš email">
         </div>
         <div class="my-3 mb-4 ms-sm-5 ms-0 d-flex align-items-center gap-3">
            <label for="phone" class="form-label form__label m-0 fw-semibold"><span class="text-danger">*</span>Mobitel</label>
            <input name="number" type="text" class="form-control" id="phone" placeholder="Vaš broj mobitela">
         </div>
         <p class="text-dark fw-semibold fs-5 m-0">Lozinka</p>
         <hr class="line__footer bg-dark m-0">
         <div class="my-3 ms-sm-5 ms-0 d-flex align-items-center justify-content-between gap-3">
            <label for="password" class="form-label form__label m-0 fw-semibold"><span class="text-danger">*</span>Lozinka</label>
            <div class="input-group">
               <input type="password" name="password" class="form-control password__form" placeholder="**********" aria-label="Input group example" aria-describedby="btnGroupAddon">
               <div class="input-group-text btn__password" id="btnGroupAddon"><i class="bi bi-eye-fill"></i></div>

            </div>
         </div>
         <div class="my-3 ms-sm-5 ms-0 d-flex align-items-center justify-content-between gap-3">
            <label for="password_repeat" class="form-label form__label m-0 fw-semibold"><span class="text-danger">*</span>Potvrdi lozinku</label>
            <div class="input-group">
               <input type="password" name="r_password" class="form-control password__form" placeholder="**********" aria-label="Input group example" aria-describedby="btnGroupAddon">
               <div class="input-group-text btn__password" id="btnGroupAddon"><i class="bi bi-eye-fill"></i></div>
            </div>
         </div>
         <div class="d-flex justify-content-end align-items-center gap-3 mt-5">
            <p class="text-secondary m-0 d-flex align-items-center gap-1">
               Pročitao sam i slažem se s 
               <button type="button" class="border-0 bg-transparent p-0 text-dark fw-bold" data-bs-toggle="modal" data-bs-target="#exampleModal">
                  Zapošljavanje
               </button>
               <input type="checkbox" name="checker">
            </p>
            <input type="submit" value="Nastavi" class="btn btn-dark">
         </div>
      </form>
   </div>

   <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" style="min-width:40%;">
         <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5 fw-bold" id="exampleModalLabel">Zapošljavanje</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <p class="m-0 mb-5 fw-semibold text-secondary">Trenutno nemamo oglašenih slobodnih radnih mjesta</p>
               <p class="m-0 mb-5 fw-semibold text-secondary">Ključ dobrih poslovnih rezultata i opstanka svake organizacije su ljudi koji rade u dotičnoj organizaciji! U Bekenda doo veliki naglasak stavljamo na dobru klimu. Svojim zaposlenicima, između ostalog, osiguravamo fleksibilno radno vrijeme, poticajno radno okruženje i, iznad svega, procese i postupke prilagođene obiteljima.
                  Kao društveno odgovorna tvrtka, nastojimo usaditi odgovornost dobročinstva ne samo unutar organizacije, već i sa stajališta svakog pojedinca koji je dio naše organizacije.
                  Rado primamo svaki zahtjev i svaku prijavu, čak i kada nemamo oglašenih pozicija. Ako vam je naša organizacija zanimljiva, pošaljite nam svoju prijavu, a mi ćemo je rado provjeriti i odgovoriti vam.
               </p>
               <p class="m-0 fw-semibold text-secondary">Sve naše natječaje možete pratiti na našoj web stranici.</p>
            </div>
         </div>
      </div>
   </div>


   <?php require_once("php/inc/footer.php") ?>
         
</body>
</html>

