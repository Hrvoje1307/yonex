<div class="container my-5 height__container">
  <?php $user->selectProductsFromCart(); ?>
  <form method="post">
      <div class="d-flex justify-content-between align-items-center">
        <h1 class="fs-1 fw-bold text-dark">Košarica</h1>
        <button name="remove_all_cart" class="btn btn-transparent text-danger text-decoration-underline fw-bold fs-5">Izbriši sve</button>
      </div>
      <div class="mt-5">
        <?php $user->changeChangeQuantity();?>
        <?php $user->displayProductsInCart();?>
      </div>
      <div class="d-flex my-5 justify-content-between align-items-center">
          <div class="input-group" style="width:30%">
            <input type="text" name="cupon_name" class="form-control" placeholder="Vaš kupon" aria-label="Recipient's username" aria-describedby="basic-addon2">
            <button type="submit" name="apply_cupon" class="input-group-text btn btn-success" id="basic-addon2">Dodaj kupon</button>
          </div>
          <?php 
          if(isset($_SESSION["cuponName"])) echo $user->printCuponCard($_SESSION["cuponName"]);
?>
      </div>
      <div class="d-flex flex-column align-items-end">
        <div class="line__cart bg-secondary"></div>
        <div class="d-flex gap-5 align-items-start">
          <div>
            <p class="fw-bold fs-4 mb-0">Ukupno</p>
            <p class="text-secondary m-0"><span class="cart__quantitiy"><?php echo $user->getData("cart")[1];?> </span><span class="quantity__word">proizvoda</span></p>
          </div>
          <p class="total fs-1 fw-bold mb-0"><span class="total__price"></span>€</p>
        </div>
        <input type="submit" name="submitCheckout" class="btn btn-lg btn-dark mt-3" value="Provjera">
      </div>
    </form>
</div>