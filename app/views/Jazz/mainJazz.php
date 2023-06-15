<?php
include __DIR__ . '/../header.php';
require_once __DIR__ . "/../../services/ArtistService.php";

$artistService = new ArtistService();

?>
<!DOCTYPE html>
<html lang="en">

<p class="title">
        Haarlem jazz
    </p>


<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css"
        integrity="sha384-HzLeBuhoNPvSl5KYnjx0BT+WB0QEEqLprO+NBkkk5gbc67FTaL7XIGa2w1L0Xbgc" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Sen' rel='stylesheet'>
    <link href="../css/indexJazz.css" rel="stylesheet">

    <title>Haarlem jazz</title>
</head>

<body>
<?php
    include __DIR__ . '/../BackArrow.php';
    ?>

    <div class="container">
        <?php echo $jazzPage[0]->htmlData; ?>


        <h2 class="perf_bands_h3">Performing bands</h2>

        <div id="performing_bands_container">
            <?php echo $artistService->generateArtistHtml('Jonna Fraser'); ?>

            <?php echo $artistService->generateArtistHtml('The Nordanians'); ?>

            <?php echo $artistService->generateArtistHtml('Ntjam Rosie'); ?>
        </div>

        <div id="performing_bands_container">
            <?php echo $artistService->generateArtistHtml('Wicked Jazz Sounds'); ?>

            <?php echo $artistService->generateArtistHtml('Tom Thomsom Assemble'); ?>

            <?php echo $artistService->generateArtistHtml('Evolve'); ?>

        </div>

        <div id="performing_bands_container">
            <?php echo $artistService->generateArtistHtml('Fox & The Mayors'); ?>

            <?php echo $artistService->generateArtistHtml('Uncle Sue'); ?>

            <?php echo $artistService->generateArtistHtml('Kris Allen'); ?>
        </div>

        <h2 class="mt-5">Day passes</h2>
        <form method="post" action="/MainJazz">
            <div class="container_dayPasses">
                <div class="card" style="width: 20rem;">
                    <div class="card-body">
                        <h6 class="card-title">All-access pass (one day)</h6>
                        <h3 class="card-subtitle mb-2" id="card_price">€35,00</h3>
                        <p class="card-text"><i class="far fa-check-square"></i> Access to all performances</p>

                        <input checked="checked" type="radio" id="Thursday" name="Day" value="2023-07-26 18:00:00">
                        <label for="Thursday">Thursday</label><br>
                        <input type="radio" id="Friday" name="Day" value="2023-07-27 18:00:00">
                        <label for="Friday">Friday</label><br>
                        <input type="radio" id="Saturday" name="Day" value="2023-07-28 18:00:00">
                        <label for="Saturday">Saturday</label><br><br>

                        <button name="jazzDayPass" type="submit" class="btn btn-primary"
                            id="buy_now_button">Buy now</button>
                    </div>
                </div>

                <div class="card" style="width: 20rem;">
                    <div class="card-body">
                        <h6 class="card-title">All-access pass (Three days)</h6>
                        <h3 class="card-subtitle mb-2" id="card_price">€80,00</h3>
                        <p class="card-text"><i class="far fa-check-square"></i> Access to all performances</p>
                        <p class="card-text"><i class="far fa-check-square"></i> Access on all days of the festival!</p>

                        <input type="hidden" name="Weekend" value="2023-07-26 18:00:00">

                        <button type="submit" name="jazzWeekendPass"
                            class="btn btn-primary" id="buy_now_button">Buy now</button>
                    </div>
                </div>
            </div>
        </form>


        <h2 class="mt-5">More performing bands</h2>

        <div id="performing_bands_container">
            <?php echo $artistService->generateArtistHtml('Myles Sanko'); ?>

            <?php echo $artistService->generateArtistHtml('Ruis Soundsystem'); ?>

            <?php echo $artistService->generateArtistHtml('The Family XL'); ?>
        </div>

        <div id="performing_bands_container">
            <?php echo $artistService->generateArtistHtml('Garu Du Nord'); ?>

            <?php echo $artistService->generateArtistHtml('Rilan & The Bombadiers'); ?>

            <?php echo $artistService->generateArtistHtml('Soul Six'); ?>

        </div>

        <div id="performing_bands_container">
            <?php echo $artistService->generateArtistHtml('Han Bennink'); ?>

            <?php echo $artistService->generateArtistHtml('Gumbo Kings'); ?>

            <?php echo $artistService->generateArtistHtml('Lilith Merlot'); ?>
        </div>

        <h2 class="mt-5 mb-5">Locations of Haarlem jazz</h2>

        <div class="container" id="locations_container">


            <div class="location">
                <h3 class="fw-bold">Patronaat</h3>
                <h4 class="fw-bold">Zijlsingel 2</h4>
                <h4 class="fw-bold">2013 DN Haarlem</h4>
                <br>
                <h3 class="fw-bold">Contact info:</h3>
                <h4>info@patronaat.nl</h4>
                <br>
                <h3 class="fw-bold">phone:</h3>
                <h4>023 - 517 58 50 </h4>
                <h4>reachable during office</h4>
                <h4>hours 10.00 u - 17.00 u</h4>
            </div>


            <div class="location">
                <h3 class="fw-bold">Grote Markt</h3>
                <h4 class="fw-bold">2011 RD Haarlem</h4>
                <h4>On the 29th of july we have 5 events
                    on the Grote Markt which are all free access. </h4>
                <br>

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



</html>
<?php
include __DIR__ . '/../footer.php';
?>