<?php 
  ob_start();
  require_once("php/inc/header.php");
  $user->updateWishlist();
  $user->previousAndNextPage();
?>
   <div class="container-lg height__container">
      <div class="row my-3">
        <div class="col-lg-3 d-none d-lg-block">
          <form method="get">
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
                      <?php $user->priceFilter();?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button bg-lightgrey text-dark fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                    Broj
                  </button>
                </h2>
                <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse show">
                  <div class="accordion-body body__filters">
                    <ul class="list-group">
                      <?php $user->shoesSize();?>
                    </ul>
                  </div>
                </div>
                <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button bg-lightgrey text-dark fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                    Spol
                  </button>
                </h2>
                <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse show">
                  <div class="accordion-body body__filters">
                    <ul class="list-group">
                      <?php $user->genderFilter();?>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button bg-lightgrey text-dark fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFour" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                    Dostupnost
                  </button>
                </h2>
                <div id="panelsStayOpen-collapseFour" class="accordion-collapse collapse show">
                  <div class="accordion-body body__filters">
                    <ul class="list-group">
                      <?php $user->availabilityFilter();?>
                    </ul>
                  </div>
                </div>
              </div>
              </div>
              <div class="mt-3 justify-content-end d-flex">
                <button class="btn btn-secondary">Pretraži</button>
              </div>
            </div>
          </form>
        </div>
        <div class="col-lg-9 col-12">
          <p class="fs-3 fw-semibold">Badminton obuća</p>
          <div class="row">
            <div class="col-12 d-lg-none d-block d-flex align-items-center justify-content-end">
              <p class="d-inline-flex gap-1 mb-0">
                <button class="btn btn-lightgrey" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                  Filteri
                </button>
              </p>
            </div>
            <div class="collapse mt-2" id="collapseExample">
              <form method="get">
                <div class="card card-body d-lg-none d-block">
                  <div class="row">
                    <div class="col-6">
                      <p class="mb-0 text-dark fw-solidbold">Cijena</p>
                    </div>
                    <div class="col-6 d-flex gap-1 align-items-center">
                      <?php $user->priceFilter();?>
                    </div>
                  </div>
                  <hr class="line__footer bg-dark">
                  <div class="row mt-3">
                    <div class="col-6">
                      <p class="mb-0 text-dark fw-solidbold">Broj</p>
                    </div>
                    <div class="col-6">
                      <ul class="list-group flex-row flex-wrap gap-2">
                        <?php $user->shoesSize();?>
                      </ul>
                    </div>
                  </div>
                  <hr class="line__footer bg-dark">
                  <div class="row mt-3">
                    <div class="col-6">
                      <p class="mb-0 text-dark fw-solidbold">Spol</p>
                    </div>
                    <div class="col-6">
                      <ul class="list-group flex-row flex-wrap gap-2">
                        <?php $user->genderFilter();?>
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
                        <?php $user->availabilityFilter();?>
                      </ul>
                    </div>
                  </div>
                  <hr class="line__footer bg-dark">
                  <div class="row">
                    <button class="col-12 btn btn-secondary">Pretraži</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <div class="row mt-3 ps-3 gap-2 justify-content-sm-start justify-content-center">
            <?php $user->printShoesFilters("shoes","badminton");?>
          </div>
          <form id="pageForm" method="post">
            <?php $user->printPagesButtons("shoes","badminton");?>
          </form>
        </div>
      </div>
   </div>
   <?php require_once("php/inc/footer.php");
ob_end_flush(); ?>
         
</body>
</html>

