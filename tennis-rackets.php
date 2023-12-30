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
                  Težina reketa
                </button>
              </h2>
              <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse show">
                <div class="accordion-body body__filters">
                  <ul class="list-group">
                    <li class="d-flex gap-2 align-items-center list-group-item border border-0">
                      <input type="checkbox" id="240g">
                      <label for="240g">240g</label>
                    </li>
                    <li class="d-flex gap-2 align-items-center list-group-item border border-0">
                      <input type="checkbox" id="250g">
                      <label for="250g">250g</label>
                    </li>
                    <li class="d-flex gap-2 align-items-center list-group-item border border-0">
                      <input type="checkbox" id="260g">
                      <label for="260g">260g</label>
                    </li>
                    <li class="d-flex gap-2 align-items-center list-group-item border border-0">
                      <input type="checkbox" id="270g">
                      <label for="270g">270g</label>
                    </li>
                    <li class="d-flex gap-2 align-items-center list-group-item border border-0">
                      <input type="checkbox" id="280g">
                      <label for="280g">280g</label>
                    </li>
                    <li class="d-flex gap-2 align-items-center list-group-item border border-0">
                      <input type="checkbox" id="290g">
                      <label for="290g">290g</label>
                    </li>
                    <li class="d-flex gap-2 align-items-center list-group-item border border-0">
                      <input type="checkbox" id="300g">
                      <label for="300g">300g</label>
                    </li>
                    <li class="d-flex gap-2 align-items-center list-group-item border border-0">
                      <input type="checkbox" id="310g">
                      <label for="310g">310g</label>
                    </li>
                    <li class="d-flex gap-2 align-items-center list-group-item border border-0">
                      <input type="checkbox" id="320g">
                      <label for="320g">320g</label>
                    </li>
                    <li class="d-flex gap-2 align-items-center list-group-item border border-0">
                      <input type="checkbox" id="330g">
                      <label for="330g">330g</label>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button bg-lightgrey text-dark fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                  Tip reketa
                </button>
              </h2>
              <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse show">
                <div class="accordion-body body__filters">
                  <ul class="list-group">
                    <li class="d-flex gap-2 align-items-center list-group-item border border-0">
                      <input type="checkbox" id="ezone">
                      <label for="ezone">Ezone</label>
                    </li>
                    <li class="d-flex gap-2 align-items-center list-group-item border border-0">
                      <input type="checkbox" id="percept">
                      <label for="percept">Percept</label>
                    </li>
                    <li class="d-flex gap-2 align-items-center list-group-item border border-0">
                      <input type="checkbox" id="vcore">
                      <label for="vcore">Vcore</label>
                    </li>
                    <li class="d-flex gap-2 align-items-center list-group-item border border-0">
                      <input type="checkbox" id="vcorePro">
                      <label for="vcorePro">Vcore Pro</label>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button bg-lightgrey text-dark fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFour" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                  Veličina ručke
                </button>
              </h2>
              <div id="panelsStayOpen-collapseFour" class="accordion-collapse collapse show">
                <div class="accordion-body body__filters">
                  <ul class="list-group">
                    <li class="d-flex gap-2 align-items-center list-group-item border border-0">
                      <input type="checkbox" id="g0">
                      <label for="g0">G0</label>
                    </li>
                    <li class="d-flex gap-2 align-items-center list-group-item border border-0">
                      <input type="checkbox" id="g1">
                      <label for="g1">G1</label>
                    </li>
                    <li class="d-flex gap-2 align-items-center list-group-item border border-0">
                      <input type="checkbox" id="g2">
                      <label for="g2">G2</label>
                    </li>
                    <li class="d-flex gap-2 align-items-center list-group-item border border-0">
                      <input type="checkbox" id="g3">
                      <label for="g3">G3</label>
                    </li>
                    <li class="d-flex gap-2 align-items-center list-group-item border border-0">
                      <input type="checkbox" id="g4">
                      <label for="g4">G4</label>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button bg-lightgrey text-dark fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFive" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                  Dostupnost
                </button>
              </h2>
              <div id="panelsStayOpen-collapseFive" class="accordion-collapse collapse show">
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
          </div>
        </div>
        <div class="col-lg-9 col-12">
          <p class="fs-3 fw-semibold">Teniski reketi</p>
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
              <div class="card card-body d-block d-lg-none">
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
                    <p class="mb-0 text-dark fw-solidbold">Težina reketa</p>
                  </div>
                  <div class="col-6">
                    <ul class="list-group flex-row flex-wrap gap-2">
                      <li class="d-flex gap-2 align-items-center list-group-item border border-0">
                        <input type="checkbox" id="240g">
                        <label for="240g">240g</label>
                      </li>
                      <li class="d-flex gap-2 align-items-center list-group-item border border-0">
                        <input type="checkbox" id="250g">
                        <label for="250g">250g</label>
                      </li>
                      <li class="d-flex gap-2 align-items-center list-group-item border border-0">
                        <input type="checkbox" id="260g">
                        <label for="260g">260g</label>
                      </li>
                      <li class="d-flex gap-2 align-items-center list-group-item border border-0">
                        <input type="checkbox" id="270g">
                        <label for="270g">270g</label>
                      </li>
                      <li class="d-flex gap-2 align-items-center list-group-item border border-0">
                        <input type="checkbox" id="280g">
                        <label for="280g">280g</label>
                      </li>
                      <li class="d-flex gap-2 align-items-center list-group-item border border-0">
                        <input type="checkbox" id="290g">
                        <label for="290g">290g</label>
                      </li>
                      <li class="d-flex gap-2 align-items-center list-group-item border border-0">
                        <input type="checkbox" id="300g">
                        <label for="300g">300g</label>
                      </li>
                      <li class="d-flex gap-2 align-items-center list-group-item border border-0">
                        <input type="checkbox" id="310g">
                        <label for="310g">310g</label>
                      </li>
                      <li class="d-flex gap-2 align-items-center list-group-item border border-0">
                        <input type="checkbox" id="320g">
                        <label for="320g">320g</label>
                      </li>
                      <li class="d-flex gap-2 align-items-center list-group-item border border-0">
                        <input type="checkbox" id="330g">
                        <label for="330g">330g</label>
                      </li>
                    </ul>
                  </div>
                </div>
                <hr class="line__footer bg-dark">
                <div class="row mt-3">
                  <div class="col-6">
                    <p class="mb-0 text-dark fw-solidbold">Tip reketa</p>
                  </div>
                  <div class="col-6">
                    <ul class="list-group flex-row flex-wrap gap-2">
                      <li class="d-flex gap-2 align-items-center list-group-item border border-0">
                        <input type="checkbox" id="ezone">
                        <label for="ezone">Ezone</label>
                      </li>
                      <li class="d-flex gap-2 align-items-center list-group-item border border-0">
                        <input type="checkbox" id="percept">
                        <label for="percept">Percept</label>
                      </li>
                      <li class="d-flex gap-2 align-items-center list-group-item border border-0">
                        <input type="checkbox" id="vcore">
                        <label for="vcore">Vcore</label>
                      </li>
                      <li class="d-flex gap-2 align-items-center list-group-item border border-0">
                        <input type="checkbox" id="vcorePro">
                        <label for="vcorePro">Vcore Pro</label>
                      </li>
                    </ul>
                  </div>
                </div>
                <hr class="line__footer bg-dark">
                <div class="row mt-3">
                  <div class="col-6">
                    <p class="mb-0 text-dark fw-solidbold">Veličina ručke</p>
                  </div>
                  <div class="col-6">
                    <ul class="list-group flex-row flex-wrap gap-2">
                      <li class="d-flex gap-2 align-items-center list-group-item border border-0">
                        <input type="checkbox" id="g0">
                        <label for="g0">G0</label>
                      </li>
                      <li class="d-flex gap-2 align-items-center list-group-item border border-0">
                        <input type="checkbox" id="g1">
                        <label for="g1">G1</label>
                      </li>
                      <li class="d-flex gap-2 align-items-center list-group-item border border-0">
                        <input type="checkbox" id="g2">
                        <label for="g2">G2</label>
                      </li>
                      <li class="d-flex gap-2 align-items-center list-group-item border border-0">
                        <input type="checkbox" id="g3">
                        <label for="g3">G3</label>
                      </li>
                      <li class="d-flex gap-2 align-items-center list-group-item border border-0">
                        <input type="checkbox" id="g4">
                        <label for="g4">G4</label>
                      </li>
                    </ul>
                  </div>
                </div>
                <hr class="line__footer bg-dark">
                <div class="row mt-3">
                  <div class="col-6">
                    <p class="mb-0 text-dark fw-solidbold">Dostupnost</p>
                  </div>
                  <div class="col-6">
                    <ul class="list-group flex-row flex-wrap gap-2">
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
            </div>
          </div>
          <div class="row mt-3 ps-3 gap-2 justify-content-sm-start justify-content-center">
            <div class="card shop__card">
              <img src="images/product-images/tennis/yell--balls.png" class="card-img-top" alt="...">
              <div class="card-body">
                  <h5 class="card-title fw-bold">Teniske loptice za trening 60 komada</h5>
                  <p class="card-text">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quasi possimus, </p>
                  <p class="fs-3 m-0"><span>110,00</span>€</p>
                  <p class="fs-5 m-0 mb-1"><span>110,00</span>€</p>
                  <p class="fs-6 fw-semibold text-success m-0 mb-3">Dostupno</p>
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
            <div class="card shop__card">
              <img src="images/product-images/tennis/yell--balls.png" class="card-img-top" alt="...">
              <div class="card-body">
                  <h5 class="card-title fw-bold">Teniske loptice za trening 60 komada</h5>
                  <p class="card-text">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quasi possimus, </p>
                  <p class="fs-3 m-0"><span>110,00</span>€</p>
                  <p class="fs-5 m-0 mb-1"><span>110,00</span>€</p>
                  <p class="fs-6 fw-semibold text-danger m-0 mb-3">Nedostupno</p>
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
        </div>
      </div>
   </div>
   <?php require_once("php/inc/footer.php") ?>
         
</body>
</html>

