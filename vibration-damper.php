<?php
  require_once ("app/config/config.php");
  require_once ("app/classes/User.php");

  $user = new User();
?>

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
   <div class="container-lg height__container">
      <div class="row my-3">
        <div class="col-lg-3 d-none d-lg-block">
          <p class="fs-3 fw-semibold">Filter</p>
          <div class="accordion" id="accordionPanelsStayOpenExample">
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button bg-lightgrey text-dark fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                  Cijena
                </button>
              </h2>
              <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show">
                <div class="accordion-body body__filters">
                  <div class="d-flex gap-1 align-items-center">
                    <input type="number" style="width:40%">
                    <p class="fw-semibold mb-0 text-nowrap">€ -</p>
                    <input type="number" style="width:40%">
                    <p class="fw-semibold mb-0">€</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button bg-lightgrey text-dark fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                  Dostupnost
                </button>
              </h2>
              <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse show">
                <div class="accordion-body body__filters">
                  <ul class="list-group">
                    <li class="d-flex gap-2 align-items-center list-group-item border border-0">
                      <input type="checkbox" id="available">
                      <label for="available">Dostupno</label>
                    </li>
                    <li class="d-flex gap-2 align-items-center list-group-item border border-0">
                      <input type="checkbox" id="unavailable">
                      <label for="unavailable">Nedostupno</label>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="mt-3 justify-content-end d-flex">
              <button class="btn btn-secondary">Pretraži</button>
            </div>
          </div>
        </div>
        <div class="col-lg-9 col-12">
          <p class="fs-3 fw-semibold">Prigušivaći vibracije</p>
          <div class="row">
            <div class="col-lg-12 col-8 d-flex gap-3">
              <div class="btn-group" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-lightgrey border border-0">Poredaj po:</button>
                <select name="sort" class="border border-top border-right border-bottom rounded-end">
                  <option value="classic">Standardno</option>
                  <option value="aToZ">Ime (A do Z)</option>
                  <option value="zToA">Ime (A do A)</option>
                  <option value="priceDown">Cijena (+/-)</option>
                  <option value="priceUp">Cijena (-/+)</option>
                </select>
              </div>
              <div class="btn-group" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-lightgrey border border-0">Pokazati:</button>
                <select name="view" class="border border-top border-right border-bottom rounded-end">
                  <option value="15">15</option>
                  <option value="25">25</option>
                  <option value="50">50</option>
                  <option value="75">75</option>
                  <option value="100">100</option>
                </select>
              </div>
            </div>
            <div class="col-4 d-lg-none d-block d-flex align-items-center justify-content-end">
              <p class="d-inline-flex gap-1 mb-0">
                <button class="btn btn-lightgrey" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                  Filteri
                </button>
              </p>
            </div>
            <div class="collapse mt-2" id="collapseExample">
              <div class="card card-body d-lg-none d-block">
                <div class="row">
                  <div class="col-6">
                    <p class="mb-0 text-dark fw-solidbold">Cijena</p>
                  </div>
                  <div class="col-6 d-flex gap-1 align-items-center">
                    <input type="number" style="width:40%">
                    <p class="fw-semibold mb-0">€ -</p>
                    <input type="number" style="width:40%">
                    <p class="fw-semibold mb-0">€</p>
                  </div>
                </div>
                <hr class="line__footer bg-dark">
                <div class="row mt-3">
                  <div class="col-6">
                    <p class="mb-0 text-dark fw-solidbold">Dostupnost</p>
                  </div>
                  <div class="col-6">
                    <ul class="list-group flex-wrap flex-row gap-2">
                      <li class="d-flex gap-2 align-items-center list-group-item border border-0">
                        <input type="checkbox" id="available">
                        <label for="available">Dostupno</label>
                      </li>
                      <li class="d-flex gap-2 align-items-center list-group-item border border-0">
                        <input type="checkbox" id="unavailable">
                        <label for="unavailable">Nedostupno</label>
                      </li>
                    </ul>
                  </div>
                </div>
                <hr class="line__footer bg-dark">
                <div class="row">
                  <button class="col-12 btn btn-secondary">Pretraži</button>
                </div>
              </div>
            </div>
          </div>
          <div class="row mt-3 ps-3 gap-2 justify-content-sm-start justify-content-center">
            <?php $user->printProductCards("classicfilters", "vibrationDamper")?>
          </div>
        </div>
      </div>
   </div>
   <?php require_once("php/inc/footer.php") ?>
         
</body>
</html>

