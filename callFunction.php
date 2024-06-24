<?php
  require_once("./php/inc/adminHeader.php");
  require_once("app/classes/dataInterface.php");

  $data = new Model($user);
  $user->relocate();
  $data->callTrainslationFunctions();
  // $data->makeJson();
?>

<div class="container my-5">
  <form method="post">
    <table class="table table-striped table-hover">
      <thead class="table__head">
        <tr>
          <th></th>
          <th>Classic filters</th>
          <th>Bags</th>
          <th>Balls</th>
          <th>Clothing</th>
          <th>Cords</th>
          <th>Rackets</th>
          <th>Shoes</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><b>Brojač</b></td>
          <td><?php echo $data->getDataFunctions()[0]["counter"]?></td>
          <td><?php echo $data->getDataFunctions()[1]["counter"]?></td>
          <td><?php echo $data->getDataFunctions()[2]["counter"]?></td>
          <td><?php echo $data->getDataFunctions()[3]["counter"]?></td>
          <td><?php echo $data->getDataFunctions()[4]["counter"]?></td>
          <td><?php echo $data->getDataFunctions()[5]["counter"]?></td>
          <td><?php echo $data->getDataFunctions()[6]["counter"]?></td>
        </tr>
        <tr>
          <td><b>Proizvodi</b></td>
          <td><?php echo $data->getDataFunctions()[0]["dataCroatian"]."/".$data->getDataFunctions()[0]["myJsonData"]?></td>
          <td><?php echo $data->getDataFunctions()[1]["dataCroatian"]."/".$data->getDataFunctions()[1]["myJsonData"]?></td>
          <td><?php echo $data->getDataFunctions()[2]["dataCroatian"]."/".$data->getDataFunctions()[2]["myJsonData"]?></td>
          <td><?php echo $data->getDataFunctions()[3]["dataCroatian"]."/".$data->getDataFunctions()[3]["myJsonData"]?></td>
          <td><?php echo $data->getDataFunctions()[4]["dataCroatian"]."/".$data->getDataFunctions()[4]["myJsonData"]?></td>
          <td><?php echo $data->getDataFunctions()[5]["dataCroatian"]."/".$data->getDataFunctions()[5]["myJsonData"]?></td>
          <td><?php echo $data->getDataFunctions()[6]["dataCroatian"]."/".$data->getDataFunctions()[6]["myJsonData"]?></td>
        </tr>
        <tr>
          <td><b>Funkcija</b></td>
          <td><button class="btn btn-primary" name="classicFiltersTranslation" type="submit" <?php echo $data->getDataFunctions()[0]["approvedTranslation"]?> >Pokreni</button></td>
          <td><button class="btn btn-primary" name="bagsTranslation" type="submit" <?php echo $data->getDataFunctions()[1]["approvedTranslation"]?>>Pokreni</button></td>
          <td><button class="btn btn-primary" name="ballsTranslation" type="submit" <?php echo $data->getDataFunctions()[2]["approvedTranslation"]?>>Pokreni</button></td>
          <td><button class="btn btn-primary" name="clothingTranslation" type="submit" <?php echo $data->getDataFunctions()[3]["approvedTranslation"]?>>Pokreni</button></td>
          <td><button class="btn btn-primary" name="cordsTranslation" type="submit" <?php echo $data->getDataFunctions()[4]["approvedTranslation"]?>>Pokreni</button></td>
          <td><button class="btn btn-primary" name="racketsTranslation" type="submit" <?php echo $data->getDataFunctions()[5]["approvedTranslation"]?>>Pokreni</button></td>
          <td><button class="btn btn-primary" name="shoesTranslation" type="submit" <?php echo $data->getDataFunctions()[6]["approvedTranslation"]?>>Pokreni</button></td>
        </tr>
        <tr>
          <td><b>Baza podataka</b></td>
          <td><?php echo $data->getDataFunctions()[0]["resultDatabase"]."/".$data->getDataFunctions()[0]["dataCroatian"]?></td>
          <td><?php echo $data->getDataFunctions()[1]["resultDatabase"]."/".$data->getDataFunctions()[1]["dataCroatian"]?></td>
          <td><?php echo $data->getDataFunctions()[2]["resultDatabase"]."/".$data->getDataFunctions()[2]["dataCroatian"]?></td>
          <td><?php echo $data->getDataFunctions()[3]["resultDatabase"]."/".$data->getDataFunctions()[3]["dataCroatian"]?></td>
          <td><?php echo $data->getDataFunctions()[4]["resultDatabase"]."/".$data->getDataFunctions()[4]["dataCroatian"]?></td>
          <td><?php echo $data->getDataFunctions()[5]["resultDatabase"]."/".$data->getDataFunctions()[5]["dataCroatian"]?></td>
          <td><?php echo $data->getDataFunctions()[6]["resultDatabase"]."/".$data->getDataFunctions()[6]["dataCroatian"]?></td>
        </tr>
        <tr>
          <td><b>Funkcija za bazu</b></td>
          <td><button class="btn btn-primary" name="classicFiltersDataBase" type="submit" <?php echo $data->getDataFunctions()[0]["approvedDataBase"]?> >Pokreni</button></td>
          <td><button class="btn btn-primary" name="bagsDataBase" type="submit" <?php echo $data->getDataFunctions()[1]["approvedDataBase"]?>>Pokreni</button></td>
          <td><button class="btn btn-primary" name="ballsDataBase" type="submit" <?php echo $data->getDataFunctions()[2]["approvedDataBase"]?>>Pokreni</button></td>
          <td><button class="btn btn-primary" name="clothingDataBase" type="submit" <?php echo $data->getDataFunctions()[3]["approvedDataBase"]?>>Pokreni</button></td>
          <td><button class="btn btn-primary" name="cordsDataBase" type="submit" <?php echo $data->getDataFunctions()[4]["approvedDataBase"]?>>Pokreni</button></td>
          <td><button class="btn btn-primary" name="racketsDataBase" type="submit" <?php echo $data->getDataFunctions()[5]["approvedDataBase"]?>>Pokreni</button></td>
          <td><button class="btn btn-primary" name="shoesDataBase" type="submit" <?php echo $data->getDataFunctions()[6]["approvedDataBase"]?>>Pokreni</button></td>
        </tr>
      </tbody>
    </table>
  </form>
</div>