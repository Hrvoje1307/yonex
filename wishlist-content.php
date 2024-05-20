<div class="container my-5 height__container">
      <h1 class="fs-2 fw-bold">Moja lista želja (<span class="items__quantity-wishlist"><?php echo $user->getWishlistData()[1]?></span> <span class="quantity__word">proizvoda</span>)</h1>
      <div class="line__footer bg-secondary my-3"></div>
      <?php $user->displayProductsInWishlist();?>
</div>