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
   <div class="container-md">
      <div class="row my-3">
        <div class="col-md-3 d-none d-md-block">
          <p class="fs-3 fw-semibold">Filter</p>
          <div class="accordion" id="accordionPanelsStayOpenExample">
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button bg-secondary text-light" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                  Cijena
                </button>
              </h2>
              <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show">
                <div class="accordion-body">
                  <div class="d-flex gap-1 align-items-center">
                    <input type="number" style="width:40%">
                    <p class="fw-semibold mb-0">€ -</p>
                    <input type="number" style="width:40%">
                    <p class="fw-semibold mb-0">€</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-9 col-12">
          <p class="fs-3 fw-semibold">Prigušivaći vibracije</p>
        </div>
      </div>
   </div>
   <?php require_once("php/inc/footer.php") ?>
         
</body>
</html>

