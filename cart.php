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
    <div class="container my-5 height__container">
      <div class="d-flex justify-content-between align-items-center">
        <h1 class="fs-1 fw-bold text-dark">Košarica</h1>
        <button class="btn btn-transparent text-danger text-decoration-underline fw-bold fs-5">Izbriši sve</button>
      </div>
      <div class="row card__products border border-1 rounded shadow-sm mb-5">
        <div class="col-12 col-lg-3 d-flex justify-content-center">
          <img src="./images/product-images/tennis/yell--balls.png" alt="Product image">
        </div>
        <div class="col-12 col-lg-4 my-5 ps-xl-0 ps-3">
          <h1 class="fs-4 fw-bold">Teniske loptice za trening 60 komada</h1>
          <p class="fs-6 fw-semibold text-success m-0">Dostupno</p>
        </div>
        <div class="col-12 col-lg-3 d-flex align-items-center justify-content-center gap-5">
          <button class="change__quantity-btn btn btn-lightgrey fs-5 fw-bold">+</button>
          <input class="mb-0 text-center border border-0 quantity__product" value="5">
          <button class="change__quantity-btn btn btn-lightgrey fs-5 px-3 fw-bold">-</button>
        </div>
        <div class="col-12 col-lg-2 mt-5 d-flex flex-column align-items-lg-end align-items-start">
          <p class=" fs-3 fw-semibold m-0"><span class="real__price">110.00</span>€</p>
          <p class="fs-5 m-0"><span>110.00</span>€</p>
          <button class="btn btn-transparent text-danger text-decoration-underline px-0">Izbriši</button>
        </div>
      </div>
      <div class="d-flex flex-column align-items-end">
        <div class="line__cart bg-secondary"></div>
        <div class="d-flex gap-5 align-items-start">
          <div>
            <p class="fw-bold fs-4 mb-0">Ukupno</p>
            <p class="text-secondary m-0"><span class="cart__quantitiy">1 </span><span class="quantity__word">proizvoda</span></p>
          </div>
          <p class="total fs-1 fw-bold mb-0"><span class="total__price"></span>€</p>
        </div>
        <button class="btn btn-lg btn-dark mt-3">Provijera</button>
      </div>
    </div>
   <?php require_once("php/inc/footer.php") ?>
         
</body>
</html>

