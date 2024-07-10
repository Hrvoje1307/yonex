<?php
   require_once("./php/inc/adminHeader.php");
   require_once("app/classes/dataInterface.php");
 
   $data = new Model($user);
   $user->relocate();
?>

<div class="container my-5">
  <h3>Osnovni podatci</h3>
  <hr>
  <div class="mb-3">
    <label for="productId" class="form-label">ID proizvoda</label>
    <input type="text" class="form-control" id="productId" value="12121">
  </div>
  <div class="mb-3">
    <label for="productName" class="form-label">Ime</label>
    <input type="text" class="form-control" id="productName" value="Znojnik">
  </div>
  <div class="mb-3">
    <label for="productImgUrl" class="form-label">Url slike</label>
    <input type="text" class="form-control" id="productImgUrl" value="www.url.hr">
  </div>
  <div class="mb-3">
    <label for="price" class="form-label">Cijena</label>
    <div class="input-group mb-3">
      <input type="text" class="form-control" id="price" value="7.34">
      <label class="input-group-text bg-primary text-light" for="price">€</label>
    </div>
  </div>
  <div class="mb-3">
    <label for="priceNoTax" class="form-label">Nabavna cijena</label>
    <div class="input-group mb-3">
      <input type="text" class="form-control" id="priceNoTax" value="6.34">
      <label class="input-group-text bg-primary text-light" for="priceNoTax">€</label>
    </div>
  </div>
  <div class="mb-3">
    <label for="productDescription" class="form-label">Opis</label>
    <input type="text" class="form-control" id="productDescription" value="12121">
  </div>
  <div class="mb-3">
    <label for="productCategory" class="form-label">Kategorija proizvoda</label>
    <input type="text" class="form-control" id="productCategory" value="12121">
  </div>
  <div class="mb-3">
    <label for="productQuantity" class="form-label">Količina</label>
    <input type="number" class="form-control" id="productQuantity" value="12121">
  </div>
</div>