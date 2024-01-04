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
   <div class="container-fluid p-5">
      <h2 class="fw-semibold text-center mb-5">Podaci o dostavi</h2>
      <div class="row">
         <div class="col-12 d-flex gap-0 mb-5 justify-content-between">
            <div class="step d-flex flex-column mt-1 align-items-center gap-1">
               <div class="circle circle__fill"><p class="mb-0">1</p></div>
               <p class="mb-0 fs-5 text-center">Informacije o dostavi</p>
            </div>
            <div class="line__footer bg-dark mt-4"></div>
            <div class="step d-flex flex-column mt-1 align-items-center gap-1">
               <div class="circle circle__nofill"><p class="mb-0">2</p></div>
               <p class="mb-0 fs-5 text-center">Plaćanje</p>
            </div>
            <div class="line__footer bg-dark mt-4"></div>
            <div class="step d-flex flex-column mt-1 align-items-center gap-1">
               <div class="circle circle__nofill"><p class="mb-0">3</p></div>
               <p class="mb-0 fs-5 text-center">Sažetak narudžbe</p>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-12 col-lg-8 mb-lg-0 mb-5">
            <h3 class="fw-semibold mb-4">Vaši podatci</h3>
            <form method="POST">
               <div class="row">
                  <div class="col-6">
                     <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="name" placeholder="name@example.com">
                        <label for="name">Ime</label>
                     </div>
                  </div>
                  <div class="col-6">
                     <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="surname" placeholder="name@example.com">
                        <label for="surname">Prezime</label>
                     </div>
                  </div>
                  <div class="col-12">
                     <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="email" placeholder="name@example.com">
                        <label for="email">Email adresa</label>
                     </div>
                  </div>
                  <div class="col-12">
                     <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="phone-number" placeholder="name@example.com">
                        <label for="phone-number">Broj mobitela</label>
                     </div>
                  </div>
                  <div class="col-9">
                     <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="address" placeholder="name@example.com">
                        <label for="address">Adresa</label>
                     </div>
                  </div>
                  <div class="col-3">
                     <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="postcode" placeholder="name@example.com">
                        <label for="postcode">ZIP kod</label>
                     </div>
                  </div>
                  <div class="col-6">
                     <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="city" placeholder="name@example.com">
                        <label for="city">Grad</label>
                     </div>
                  </div>
                  <div class="col-6">
                     <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="coutny" placeholder="name@example.com">
                        <label for="coutny">Županija</label>
                     </div>
                  </div>
                  <div class="col-12 d-flex gap-3 justify-content-end">
                     <a href="cart.php" type="button" class="btn btn-lg btn-outline-dark">Nazad</a>
                     <a href="payment-info.php" type="button" class="btn btn-lg btn-dark">Spremi i nastavi</a>
                  </div>
               </div>
            </form>
         </div>
         <div class="col-12 col-lg-4">
            <div class="row">
               <div class="col-12 d-flex justify-content-between align-items-center">
                  <h3 class="fw-semibold mb-4">Sažetak narudžbe</h3>
                  <a href="cart.php" class="text-underline text-dark fw-semibold">Uredi košaricu</a>
               </div>
               <div class="col-12">
                  <div class="info__cart d-flex align-items-center justify-content-between">
                     <p class="mb-0 fs-5">Cijena proizvoda</p>
                     <p class="mb-0 fs-5 fw-bold"><span class="price__products">100 </span>€</p>
                  </div>
                  <div class="info__cart d-flex align-items-center justify-content-between">
                     <p class="mb-0 fs-5">Cijena poštarine</p>
                     <p class="mb-0 fs-5 fw-bold"><span class="price__shipping">200 </span>€</p>
                  </div>
                  <div class="info__cart d-flex align-items-center justify-content-between mt-5 fs-5">
                     <p class="mb-0 fs-5 fw-bold">Ukupna cijena</p>
                     <p class="mb-0 fs-5 fw-bold"><span class="toal__price__checkout"> </span> €</p>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>     
</body>
</html>

