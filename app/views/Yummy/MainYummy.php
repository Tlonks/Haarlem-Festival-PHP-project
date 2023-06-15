<!DOCTYPE html>

<html>


<?php
include __DIR__ . '/../header.php';
?>

<p class="title">
  Yummy
</p>

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="/css/Main.css" rel="stylesheet">
  <link href="/css/MainYummy.css" rel="stylesheet">
</head>

<body>
  <!-- back button -->
  <?php
  include __DIR__ . '/../BackArrow.php';
  ?>

  <!-- image met tekst, intro -->
  <div id="yummyIntro">
    <?php echo $yummyPage[0]->htmlData; ?>

    <!-- restaurants -->
    <div id="yummyItems">
      <?php

      for ($i = 0; $i < count($contentRestaurants); $i++) {

      ?>
        <div id="yummyRestaurant">
          <?php $dataUri2 = "data:image/png;charset=utf;base64," . base64_encode($contentRestaurants[$i]->image) ?>
          <img id="picture" id="imageContentCards" src="<?php echo $dataUri2; ?>" alt="Image is not shown" width="50%">

          <img id="speechbubblePoint" src="/images/General/speechbubble_thingy.png" alt="Image is not shown">

          <!-- text white square -->
          <div id="speechbubble">
            <b><?php echo $contentRestaurants[$i]->title ?></b>
            <div id="stars">
              <?php for ($j = 0; $j < $contentRestaurants[$i]->stars; $j++) { ?> <img src="/images/Yummy/star.png" alt="Image is not shown" width="8%"> <?php } ?>
              <b><?php echo number_format($contentRestaurants[$i]->stars, 1, '.', ''); ?></b>
            </div>

            <p id="speechbubbleText">
              <b>Price: </b> € <?php echo $contentRestaurants[$i]->price ?><br>
              <b>Duration: </b> <?php echo $contentRestaurants[$i]->duration ?><br>
              <b>Type of food: </b> <?php echo $contentRestaurants[$i]->typeOfFood ?><br>
              <b>Location: </b> <?php echo $contentRestaurants[$i]->location ?><br>
            </p>

            <!-- see more button -->
            <a href="/YummyInformation">
              <form method="POST">
                <button class="btn seeMoreButton" name="seeMoreRestaurantsBtn" value="<?php echo $contentRestaurants[$i]->title; ?>">
                  <b> See more</b>
                  <div id="seeMoreArrow">
                    <use xlink:href="#home" />
                    <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                      <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z" />
                    </svg>
                  </div>
                </button>
              </form>
            </a>
          </div>
        </div>
      <?php
      }

      if (count($contentRestaurants) % 2 != 0) {
      ?> <div class="fillDiv"></div> <?php } ?>
    </div>
    
    <?php if (isset($popUp)) {
        include __DIR__ . "/../timetable/timeTablePopUp.php";
        $_SESSION['showPopUpMessage'] = NULL;
        $popUp = NULL;
    }
    ?>

</body>

<?php
include __DIR__ . '/../footer.php';
?>

<style>
#picture{
  border-radius: 15px;
}
</style>