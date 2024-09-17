
   <?php require_once("php/inc/header.php");?>
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
            <?php echo $user->getProductsRackets("tennis");?>
         </div>
      </div>
      <div class="row flex-lg-row flex-column-reverse">
         <div class="col-lg-6 col-12 d-flex my-lg-0 my-3 justify-content-between">
            <?php echo $user->getProductsRackets("badminton");?>
         </div>
         <div class="col-lg-6 col-12 px-0 main__sport--container" data-name="Badminton">
            <img src="images/home-page/badminton--main.png" class="img-fluid main__sport--img" alt="Badminton main page">
         </div>
      </div>
   </div>

   <?php require_once("php/inc/footer.php") ?>
         
</body>
</html>

