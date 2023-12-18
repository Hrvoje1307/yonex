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
   <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">
         <div class="carousel-item active">
            <img src="images/home-page/main--image1.png" class="d-block w-100" alt="...">
         </div>
         <div class="carousel-item">
            <img src="images/home-page/main--image2.png" class="d-block w-100" alt="...">
         </div>
         <div class="carousel-item">
            <img src="images/home-page/main--image3.png" class="d-block w-100" alt="...">
         </div>
         <div class="carousel-item">
            <img src="images/home-page/main--image4.png" class="d-block w-100" alt="...">
         </div>
         <div class="carousel-item">
            <img src="images/home-page/main--image5.png" class="d-block w-100" alt="...">
         </div>
         <div class="carousel-item">
            <img src="images/home-page/main--image6.png" class="d-block w-100" alt="...">
         </div>
         <div class="carousel-item">
            <img src="images/home-page/main--image7.png" class="d-block w-100" alt="...">
         </div>
         <div class="carousel-item">
            <img src="images/home-page/main--image8.png" class="d-block w-100" alt="...">
         </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
         <i class="bi bi-chevron-left fs-1 text-light" aria-hidden="true"></i> 
         <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
         <i class="bi bi-chevron-right fs-1 text-light" aria-hidden="true"></i> 
         <span class="visually-hidden">Next</span>
      </button>
   </div>
   <div class="container my-5">
      <div class="row my-3">
         <div class="col-lg-6 col-12 px-0 main__sport--container" data-name="Tenis">
            <img src="images/home-page/tenis--main.png" class="img-fluid main__sport--img" alt="Tennis main page">
         </div>
         <div class="col-lg-6 col-12 d-flex my-lg-0 my-3 justify-content-between">
            <div class="card" style="width: 49%;">
               <img src="images/product-images/tennis/yell--balls.png" class="card-img-top" alt="...">
               <div class="card-body">
                  <h5 class="card-title fw-bold">Teniske loptice za trening 60 komada</h5>
                  <p class="card-text">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quasi possimus, </p>
                  <p class="fs-3 m-0"><span>110,00</span>€</p>
                  <p class="fs-5 m-0 mb-3"><span>110,00</span>€</p>
                  <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                     <a href="#" class="btn btn-light d-flex gap-1 justify-content-center align-items-center">
                        <i class="bi bi-cart-fill"></i>
                        <p class="lead m-0">Dodaj u košaricu</p>
                     </a>
                     <a href="#" class="btn btn-light d-flex gap-1 justify-content-center align-items-center">
                        <i class="bi bi-heart"></i>
                     </a>
                  </div>
               </div>
            </div>
            <div class="card" style="width: 49%;">
               <img src="images/product-images/tennis/yell--balls.png" class="card-img-top" alt="...">
               <div class="card-body">
                  <h5 class="card-title fw-bold">Teniske loptice za trening 60 komada</h5>
                  <p class="card-text">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quasi possimus, </p>
                  <p class="fs-3 m-0"><span>110,00</span>€</p>
                  <p class="fs-5 m-0 mb-3"><span>110,00</span>€</p>
                  <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                     <a href="#" class="btn btn-light d-flex gap-1 justify-content-center align-items-center">
                        <i class="bi bi-cart-fill"></i>
                        <p class="lead m-0">Dodaj u košaricu</p>
                     </a>
                     <a href="#" class="btn btn-light d-flex gap-1 justify-content-center align-items-center">
                        <i class="bi bi-heart"></i>
                     </a>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="row flex-lg-row flex-column-reverse">
         <div class="col-lg-6 col-12 d-flex my-lg-0 my-3 justify-content-between">
            <div class="card" style="width: 49%;">
               <img src="images/product-images/tennis/yell--balls.png" class="card-img-top" alt="...">
               <div class="card-body">
                  <h5 class="card-title fw-bold">Teniske loptice za trening 60 komada</h5>
                  <p class="card-text">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quasi possimus, </p>
                  <p class="fs-3 m-0"><span>110,00</span>€</p>
                  <p class="fs-5 m-0 mb-3"><span>110,00</span>€</p>
                  <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                     <a href="#" class="btn btn-light d-flex gap-1 justify-content-center align-items-center">
                        <i class="bi bi-cart-fill"></i>
                        <p class="lead m-0">Dodaj u košaricu</p>
                     </a>
                     <a href="#" class="btn btn-light d-flex gap-1 justify-content-center align-items-center">
                        <i class="bi bi-heart"></i>
                     </a>
                  </div>
               </div>
            </div>
            <div class="card" style="width: 49%;">
               <img src="images/product-images/tennis/yell--balls.png" class="card-img-top" alt="...">
               <div class="card-body">
                  <h5 class="card-title fw-bold">Teniske loptice za trening 60 komada</h5>
                  <p class="card-text">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quasi possimus, </p>
                  <p class="fs-3 m-0"><span>110,00</span>€</p>
                  <p class="fs-5 m-0 mb-3"><span>110,00</span>€</p>
                  <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                     <a href="#" class="btn btn-light d-flex gap-1 justify-content-center align-items-center">
                        <i class="bi bi-cart-fill"></i>
                        <p class="lead m-0">Dodaj u košaricu</p>
                     </a>
                     <a href="#" class="btn btn-light d-flex gap-1 justify-content-center align-items-center">
                        <i class="bi bi-heart"></i>
                     </a>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-lg-6 col-12 px-0 main__sport--container" data-name="Badminton">
            <img src="images/home-page/badminton--main.png" class="img-fluid main__sport--img" alt="Badminton main page">
         </div>
      </div>
   </div>

   <footer class="bg-darkgrey">
      <div class="container py-5">
         <div class="row">
            <div class="col-sm-6 col-12 d-flex justify-content-sm-start justify-content-center">
               <img src="images/brand/logo.png" alt="Logo of our company">
            </div>
            <div class="col-sm-6 col-12 d-flex justify-content-sm-end justify-content-center">
               <ul class="list__footer d-flex gap-3 mb-0 justify-content-center p-3 p-sm-0">
                  <li><a href="#"><i class="bi bi-facebook fs-3 text-secondary"></i></a></li>
                  <li><a href="#"><i class="bi bi-instagram fs-3 text-secondary"></i></a></li>
                  <li><a href="#"><i class="bi bi-youtube fs-3 text-secondary"></i></a></li>
                  <li><a href="#"><i class="bi bi-twitter fs-3 text-secondary"></i></a></li>
               </ul>
            </div>
         </div>
         <hr class="line__footer bg-secondary">
         <div class="row py-2">
            <div class="col">
               <ul class="list__footer d-flex gap-3 mb-0 justify-content-sm-start justify-content-center flex-sm-row flex-column p-0">
                  <li class="text-center text-sm-left"><a href="#" class="text-uppercase text-light text-decoration-none fw-bold">Tenis</a></li>
                  <li class="text-center text-sm-left"><a href="#" class="text-uppercase text-light text-decoration-none fw-bold">Badminton</a></li>
                  <li class="text-center text-sm-left"><a href="#" class="text-uppercase text-light text-decoration-none fw-bold">Torbe</a></li>
                  <li class="text-center text-sm-left"><a href="#" class="text-uppercase text-light text-decoration-none fw-bold">Odijeća</a></li>
                  <li class="text-center text-sm-left"><a href="#" class="text-uppercase text-light text-decoration-none fw-bold">Pribor</a></li>
               </ul>
            </div>
         </div>
         <hr class="line__footer bg-secondary">
         <div class="row flex-xl-row flex-column-reverse align-items-center align-items-xl-start">
            <div class="col-sm-6 col-12 d-flex gap-3 flex-column">
               <div class="footer__info text-center text-sm-left d-flex justify-content-center justify-content-xl-start"></div>
               <div class="justify-content-center justify-content-xl-start d-flex"><img src="images/paymentsImages/payment-methods.png" alt="Payment methods"></div>
            </div>
            <div class="list__footer--yonex col-sm-6 col-12 d-flex justify-content-center justify-content-xl-end py-xl-0 py-3">
               <ul class="list__footer  p-0 mb-0 d-flex flex-column flex-sm-row gap-3">
                  <li class="text-center text-sm-left"><a class="text-lightgrey text-decoration-none" href="#">O Yonex-u</a></li>
                  <li class="text-center text-sm-left"><a class="text-lightgrey text-decoration-none" href="#">O tvrtci</a></li>
                  <li class="text-center text-sm-left"><a class="text-lightgrey text-decoration-none" href="#">Zapošljavanje</a></li>
                  <li class="text-center text-sm-left"><a class="text-lightgrey text-decoration-none" href="#">Sigurnost osobnih podataka</a></li>
               </ul>
            </div>
         </div>
      </div>
   </footer>
         
</body>
</html>

