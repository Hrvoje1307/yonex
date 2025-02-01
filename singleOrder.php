<?php
  require_once("./php/inc/adminHeader.php");
  require_once("app/classes/dataInterface.php");

  $data = new Model($user);
  $user->relocate();

  $order_id = isset($_GET["id"]) ? $_GET["id"] : null;
  $orderNum = isset($_GET["orderNum"]) ? $_GET["orderNum"] : null;

  $user->getDataAboutOrder($order_id);
  $user->deleteProductFromOrder($order_id);
?>

<div class="container my-5">
  <h1>Narudžba <?php echo $orderNum;?></h1>
  <hr>
  <form method="post">
    <div class="mb-3">
      <label for="customer" class="form-label">Naručitelj</label>
      <input name="customer" type="text" class="form-control" id="customer" value="<?php echo $user->getDataAboutOrder($order_id)["fullName"];?>">
    </div>
    <div class="mb-3">
      <label for="email" class="form-label">Kontak email</label>
      <input name="email" type="email" class="form-control" id="email" value="<?php echo $user->getDataAboutOrder($order_id)["email"];?>">
    </div>
    <div class="mb-3">
      <label for="phoneNumber" class="form-label">Kontak mobitel</label>
      <input name="phoneNumber" type="text" class="form-control" id="phoneNumber" value="<?php echo $user->getDataAboutOrder($order_id)["phoneNumber"];?>">
    </div>
    <div class="mb-3">
      <label for="address" class="form-label">Adresa stanovanja</label>
      <input name="address" type="text" class="form-control" id="address" value="<?php echo $user->getDataAboutOrder($order_id)["address"];?>">
    </div>
    <div class="mb-3">
      <label for="postcode" class="form-label">Poštanski broj</label>
      <input name="postcode" type="text" class="form-control" id="postcode" value="<?php echo $user->getDataAboutOrder($order_id)["postcode"];?>">
    </div>
    <div class="mb-3">
      <label for="city" class="form-label">Grad</label>
      <input name="city" type="text" class="form-control" id="city" value="<?php echo $user->getDataAboutOrder($order_id)["city"];?>">
    </div>
    <input type="submit" name="submitOrders" value="Promijeni" class="btn btn-primary">
  </form>

  <h1 class="mt-5">Proizvodi u narudžbi</h1>
  <hr>
  <div class="d-flex flex-wrap gap-5">
    <?php $user->printOrderProductCards($order_id);?>
  </div>
</div>