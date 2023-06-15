<?php
include __DIR__ . '/../header.php';
?>

<!DOCTYPE html>

<html>

<head>
  <link href="../css/History/mainHistory.css" rel="stylesheet">
  <link href="/css/Main.css" rel="stylesheet">
</head>

<body>
  <p class="title">
    Stroll Through History
  </p>
  <?php
    include __DIR__ . '/../BackArrow.php';
    ?>
  <div class="historyStructure">
   <?php echo $historyPage[0]->htmlData; ?>


    <div class="historySights">
      <h1 class="sightHeader">Sights</h1>
      <div class="fillDiv"></div>
      <?php
      foreach ($contentSights as $row) {
        ?>
        <div class="historySightInformation">
          <?php $dataUri = "data:image/jpg;charset=utf;base64," . base64_encode($row->image) ?>
          <img src="<?php echo $dataUri; ?>" alt="Image is not shown" width="50%">
          <img class="speech" src="/images/General/speechbubble_thingy.png" alt="Image is not shown">
          <div class="speechbubble">
            <h3> <b>
                <?php echo $row->title ?>
              </b></h3>
            <p class="speechbubbleText">
              <?php echo $row->information ?><br>
            </p>
            <a href="/historyInformation">
              <form method="POST">
                <button name="sightInformationBtn" value="<?php echo $row->title; ?>" class="btn" id="seeMoreButton">
                  See more

                  <div id="seeMoreArrow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor"
                      class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                      <path fill-rule="evenodd"
                        d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z" />
                    </svg>
                  </div>
                </button>
              </form>
            </a>
          </div>
        </div>
        <?php
      }
      ?>
      <?php
      if (count($contentSights) % 2 != 0) {
        ?>
        <div class="fillDiv"></div>
        <?php
      }
      ?>
    </div>
  </div>

</body>



<?php
include __DIR__ . '/../footer.php';
?>

</html>