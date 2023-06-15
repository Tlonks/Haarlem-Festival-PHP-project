<?php
include __DIR__ . '/../header.php';
?>

<!DOCTYPE html>

<html>

<head>
  <link href="../css/History/historyInformation.css" rel="stylesheet">
  <link href="/css/Main.css" rel="stylesheet">
</head>

<body>
  <p class="title">
    Stroll Through History
  </p>
  <?php
    include __DIR__ . '/../BackArrow.php';
    ?>
  <div class="sightInformationStructure">
    <h1 class="sightHeader"><?php echo $informationSight[0]->title  ?></h1>
    <div class="fillDiv"></div>

    <div class="contentText">
      <?php echo $informationSight[0]->headText  ?>
    </div>



    <div class="content">
      <?php
      $firstImage = "data:image/jpg;charset=utf;base64," . base64_encode($informationSight[0]->firstImage);
      ?>
      <img src="<?php echo $firstImage  ?>" alt="Image is not shown" width="100%">
    </div>

    <div class="content">
      <?php
      $secondImage = "data:image/jpg;charset=utf;base64," . base64_encode($informationSight[0]->secondImage);
      ?>
      <img src="<?php echo $secondImage  ?>" alt="Image is not shown" width="100%">

    </div>

    <div class="content">
      <?php
      $thirdImage = "data:image/jpg;charset=utf;base64," . base64_encode($informationSight[0]->thirdImage);
      ?>
      <img src="<?php echo $thirdImage  ?>" alt="Image is not shown" width="100%">

    </div>

  </div>

  <div class="contentinformation">
    <div class="contentLargeText">
      <?php echo $informationSight[0]->bodyText  ?>
    </div>
    <?php
    $mapOfHaarlem = "data:image/jpg;charset=utf;base64," . base64_encode($informationSight[0]->mapOfHaarlem);
    ?>
    <img class="mapOfHaarlem" src="<?php echo $mapOfHaarlem  ?>" alt="Image is not shown" width="87%">

  </div>
  <div class="fillDiv"></div>
</body>



<?php
include __DIR__ . '/../footer.php';
?>

</html>