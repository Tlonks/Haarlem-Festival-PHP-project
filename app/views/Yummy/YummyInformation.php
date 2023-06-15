<!DOCTYPE html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="/css/Main.css" rel="stylesheet">
    <link href="/css/YummyInfo.css" rel="stylesheet">
</head>

<?php
include __DIR__ . '/../header.php';
?>

<p class="title">
    Yummy
</p>

<body>
    <!-- back button -->
    <?php
    include __DIR__ . '/../BackArrow.php';
    ?>

    <!-- image met tekst, intro -->
    <div id="MrAndMrsIntro">
        <div id="MrAndMrsInfo">
            <?php $firstImage = "data:image/jpg;charset=utf;base64," . base64_encode($informationRestaurants[0]->firstImage); ?>
            <img id="picture" src="<?php echo $firstImage ?>" alt="Image is not shown" width="40%">
            <div id="MrAndMrsIntroText">
                <h2>
                    <?php echo $informationRestaurants[0]->title; ?>
                </h2>
                <p>
                    <?php echo $informationRestaurants[0]->headText; ?>
                </p>
                <div id="emptySpace"></div>
                <a href="/ReservationSystem">
                    <button class="btn" id="makeReservationButton">
                        <b>Make a reservation</b>
                        <div id="makeReservationArrow">
                            <svg xmlns="http://www.w3.org/2000/svg" width="42" height="42" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z" />
                            </svg>
                        </div>
                    </button>
                </a>
            </div>
        </div>

        <div class="structureSquares">
            <div class="whiteSquare">

                <h3>Time slots</h3>
                <p>
                    <?php echo $informationRestaurants[0]->timeSlotsText; ?>
                </p>
                <h5>Everyday</h5>
                <div id="timeSlotsTable">
                    <?php

                    $date = date("H:i", strtotime($informationRestaurants[0]->time));
                    for ($i = 0; $i < $informationRestaurants[0]->sessions; $i++) {
                        $date2 = date("H:i", strtotime($date . '+ ' . ($informationRestaurants[0]->duration) . 'minutes')); ?>
                        <div id="tableBorder"><b><?php echo $date . "-" . $date2; ?> </b></div>
                    <?php $date = $date2;
                    }
                    ?>
                </div>
            </div>
            <?php $secondImage = "data:image/jpg;charset=utf;base64," . base64_encode($informationRestaurants[0]->secondImage); ?>
            <img id="picture" src="<?php echo $secondImage ?>" alt="Image is not shown" width="30%">
        </div>

        <!-- Location -->
        <div class="structureSquares">
            <?php $thirdImage = "data:image/jpg;charset=utf;base64," . base64_encode($informationRestaurants[0]->thirdImage); ?>
            <img id="picture" src="<?php echo $thirdImage ?>" alt="Image is not shown" width="30%">

            <div class="whiteSquare">

                <h3>Location</h3>
                <br>
                <p>
                    <?php echo $informationRestaurants[0]->street; ?> <?php echo $informationRestaurants[0]->houseNumber; ?> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <?php echo $informationRestaurants[0]->postalCode; ?> &nbsp; <?php echo $informationRestaurants[0]->city; ?> <br><br>
                    <a class="links" href="<?php echo $informationRestaurants[0]->routeURL; ?>">plan the route></a> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <a class="links" href="<?php echo $informationRestaurants[0]->websiteURL; ?>">To the website></a>
                </p>

                <div id="line"></div>
                <br><br>
            </div>
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