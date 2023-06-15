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
  <link href="/css/reservationSystem.css" rel="stylesheet">
</head>

<body>
  <!-- back button -->
  <?php
  include __DIR__ . '/../BackArrow.php';
  ?>

  <div id="reservationSystemStructure">

    <h3><?php echo $_SESSION['restaurantName']; ?></h3>

    <div id="whiteSquare">
      <div id="itemsWhiteSquare">
        <h4> Reservation</h4> <br>
        <form method="POST">

        <!-- * heeft veel moeite gekost om de styling van het reserverings in orde te maken -->
          <h5>*Amount of people</h5>
          <div id="amountOfPeople">
            <button name="peopleBtn1" id="tableBorder1" class="tableBorder" value="1"><b>1</b></button>
            <?php for ($i = 2; $i < 14; $i++) { ?>
              <button name="peopleBtn2" class="tableBorder" id="<?php echo "tableBorder" . $i ?>" value="<?php echo $i ?>"><b><?php echo $i ?></b></button>
            <?php } ?>
            <button name="peopleBtn3" id="tableBorder14" value="14"><b>14</b></button>
          </div> <br><br>

          <h5>*Date</h5>
          <div class="date">
            <div id="dateTable">
              <?php
              for ($i = 0; $i < count($yummyEventInfo); $i++) {
              ?> <button id="date" class="date<?php echo date("Y-m-d", strtotime($yummyEventInfo[$i]->date)); ?>" name="date" value="<?php echo date("Y-m-d", strtotime($yummyEventInfo[$i]->date)); ?>"><b><?php echo date("d-m-Y", strtotime($yummyEventInfo[$i]->date)); ?></b></button> <?php } ?>
            </div><br><br>
          </div>

          <h5>*Time</h5>
          <div id="timeSlotsTable">
            <?php
            $date = date("H:i", strtotime($informationRestaurants[0]->time));
            for ($i = 0; $i < $informationRestaurants[0]->sessions; $i++) {
              $date2 = date("H:i", strtotime($date . '+ ' . ($informationRestaurants[0]->duration) . 'minutes')); ?>
              <button id="tableBr" class="time<?php echo date("Hi", strtotime($date)); ?>" name="time" value="<?php echo date("Hi", strtotime($date)); ?>"><b><?php echo $date . "-" . $date2; ?></b></button>
            <?php $date = $date2; } ?>
          </div> <br><br>

          <h5>Special requests </h5>
          <div class="btnAndText">
            <textarea id="specialRequests" name=specialRequests class="form-control" placeholder="wheelchair, allergies"><?php if (isset($_SESSION["specialRequests"])) {
                                                                                                                          } ?></textarea>
            <button name="makeReservation" class="btn" id="makeReservationBtn">
              Make reservation
              <svg id="btnArrow" xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z" />
              </svg>
            </button>
          </div>
        </form>
        <div id="errorMessage"><?php echo $errorMessage ?></div>
        <br><br>
      </div>
    </div>

    <div class="conditions">
      <br> **Reservation is mandatory.
      <br> **A reservation fee of €10, - per person will be charged when a reservation is made on the Haarlem Festival site.
      <br> **This fee will be deducted from the final check on visiting the restaurant.
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

#tableBr,
#tableBr:hover {
  width: 100%;
  color: black;
  border-color: black;
}

</style>