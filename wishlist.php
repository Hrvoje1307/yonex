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
      <h1 class="fs-2 fw-bold">Moja lista želja (<span class="items__quantity-wishlist">2</span> <span class="quantity__word">proizvoda</span>)</h1>
      <div class="line__footer bg-secondary my-3"></div>
      <div class="card mb-3 card__products">
        <div class="row g-0">
          <div class="col-md-4 d-flex justify-content-center">
            <img src="./images/product-images/tennis/yell--balls.png" class="img-fluid rounded-start" alt="This is image of product in whishlist">
          </div>
          <div class="col-md-8">
            <div class="card-body">
              <div class="row">
                <div class="col-6">
                  <h5 class="card-title fs-3 fw-bold">Teniske loptice za trening 60 komada</h5>
                </div>
                <div class="col-6 pe-5 d-flex justify-content-end align-items-sm-start align-items-center"><i class="fs-5 text-danger bi bi-trash-fill"></i></div>
              </div>
              <p class="card-text">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Aliquid repellat totam suscipit asperiores dolore id quod, nulla eligendi vero ea accusantium, sunt maiores recusandae facere enim praesentium quas error delectus.</p>
              <div class="row">
                <div class="col-6 d-flex align-items-center gap-3">
                  <p class="fs-3 fw-semibold m-0"><span>110,00</span>€</p>
                  <p class="fs-5 m-0"><span>110,00</span>€</p>
                </div>
                <div class="col-6 d-flex justify-content-end">
                  <button class="btn btn-lg btn-dark">Dodaj u kosaricu</button>
                </div>
              </div>
              <div class="d-flex justify-content-start">
                <p class="fs-6 fw-semibold text-success m-0">Dostupno</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card mb-3 card__products">
        <div class="row g-0">
          <div class="col-md-4 d-flex justify-content-center">
            <img src="./images/product-images/tennis/yell--balls.png" class="img-fluid rounded-start" alt="This is image of product in whishlist">
          </div>
          <div class="col-md-8">
            <div class="card-body">
              <div class="row">
                <div class="col-6">
                  <h5 class="card-title fs-3 fw-bold">Teniske loptice za trening 60 komada</h5>
                </div>
                <div class="col-6 pe-5 d-flex justify-content-end align-items-sm-start align-items-center"><i class="fs-5 text-danger bi bi-trash-fill"></i></div>
              </div>
              <p class="card-text">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Aliquid repellat totam suscipit asperiores dolore id quod, nulla eligendi vero ea accusantium, sunt maiores recusandae facere enim praesentium quas error delectus.</p>
              <div class="row">
                <div class="col-6 d-flex align-items-center gap-3">
                  <p class="fs-3 fw-semibold m-0"><span>110,00</span>€</p>
                  <p class="fs-5 m-0"><span>110,00</span>€</p>
                </div>
                <div class="col-6 d-flex justify-content-end">
                  <button class="btn btn-lg btn-dark" disabled>Dodaj u kosaricu</button>
                </div>
              </div>
              <div class="d-flex justify-content-start">
                <p class="fs-6 fw-semibold text-danger m-0">Nedostupno</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
   <?php require_once("php/inc/footer.php") ?>
         
</body>
</html>

