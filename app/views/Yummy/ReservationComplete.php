<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="/css/Main.css" rel="stylesheet">
    <link href="/css/reservationComplete.css" rel="stylesheet">
</head>

<?php
include __DIR__ . '/../header.php';
?>
<p class="title">
    Yummy
</p>

<body>
    <div id="reservationSystemStructure">

        <h3><?php echo $_SESSION['restaurantName'] ?></h3>

        <div id="whiteSquare">
            <div id="itemsWhiteSquare">
                <div id="title"> Reservation is added to the shoppingcart</div>
                <div class="d-flex">
                    <div id="text">
                        Amount of people: <br>
                        Date:<br>
                        Time:<br>
                        Special requests:
                    </div>

                    <div id="data">
                        <b><?php echo $_SESSION['amountOfPeople']; ?> <br></b>
                        <b><?php echo date("d-m-Y", strtotime($_SESSION['date']));  ?> <br></b>
                        <b><?php echo date("H:i", strtotime($_SESSION['time']));  ?> <br></b>
                        <b><?php echo $_SESSION['specialRequests']; ?></b>
                    </div>
                </div>
                <a href="/" id="homepageBtn">
                    Home
                </a>

            </div>
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

