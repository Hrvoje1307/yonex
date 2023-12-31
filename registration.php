<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="icon" type="image/x-icon" href="./images/brand/favicon.jpg">
   <!-- BOOTSRAP -->
   <link rel="stylesheet" href="./css/style.css">
   <link rel="stylesheet" href="./css/my-style.css">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
   <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
   <script type="module" defer src="js/controller/incController.js"></script>

   <title>Yonex</title>
</head>
<body>
   <?php require_once("php/inc/header.php") ?>
  

   <div class="container-md py-5 height__container">
      <h2 class="text-dark fw-bolder fs-1">Registracija</h2>
      <a href="login.php" class="text-dark text-decoration-none">Imate račun? Prijavite se</a>
      <form action="POST" class="my-2">
         <p class="text-dark fw-semibold fs-5 m-0">Osobni podaci</p>
         <hr class="line__footer bg-dark m-0">
         <div class="my-3 ms-sm-5 ms-0  d-flex align-items-center justify-content-between gap-3">
            <label for="name" class="form-label form__label m-0 fw-semibold"><span class="text-danger">*</span>Ime</label>
            <input type="text" class="form-control" id="name" placeholder="Vaše ime">
         </div>
         <div class="my-3 ms-sm-5 ms-0 d-flex align-items-center justify-content-between gap-3">
            <label for="surname" class="form-label form__label m-0 fw-semibold"><span class="text-danger">*</span>Prezime</label>
            <input type="text" class="form-control" id="surname" placeholder="Vaše prezime">
         </div>
         <div class="my-3 ms-sm-5 ms-0 d-flex align-items-center gap-3">
            <label for="email" class="form-label form__label m-0 fw-semibold"><span class="text-danger">*</span>Email adresa</label>
            <input type="email" class="form-control" id="email" placeholder="Vaš email">
         </div>
         <div class="my-3 mb-4 ms-sm-5 ms-0 d-flex align-items-center gap-3">
            <label for="phone" class="form-label form__label m-0 fw-semibold"><span class="text-danger">*</span>Mobitel</label>
            <input type="text" class="form-control" id="phone" placeholder="Vaš broj mobitela">
         </div>
         <p class="text-dark fw-semibold fs-5 m-0">Lozinka</p>
         <hr class="line__footer bg-dark m-0">
         <div class="my-3 ms-sm-5 ms-0 d-flex align-items-center justify-content-between gap-3">
            <label for="password" class="form-label form__label m-0 fw-semibold"><span class="text-danger">*</span>Lozinka</label>
            <input type="password" class="form-control" id="password" placeholder="**********">
         </div>
         <div class="my-3 ms-sm-5 ms-0 d-flex align-items-center justify-content-between gap-3">
            <label for="password_repeat" class="form-label form__label m-0 fw-semibold"><span class="text-danger">*</span>Potvrdi lozinku</label>
            <input type="password" class="form-control" id="password_repeat" placeholder="*********">
         </div>
         <div class="d-flex justify-content-end align-items-center gap-3 mt-5">
            <p class="text-secondary m-0 d-flex align-items-center gap-1">
               Pročitao sam i slažem se s 
               <button type="button" class="border-0 bg-transparent p-0 text-dark fw-bold" data-bs-toggle="modal" data-bs-target="#exampleModal">
                  Zapošljavanje
               </button>
               <input type="checkbox">
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

