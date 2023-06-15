<?php
include __DIR__ . '/../header.php';
?>
<p class="title">
    Dance
</p>

<link href="/../css/Main.css" rel="stylesheet">
<link href="/../css/dance.css" rel="stylesheet">
<link href="../css/indexJazz.css" rel="stylesheet">
<link href="../css/HomePage/homePage.css" rel="stylesheet">
<title>Dance</title>
</head>

<body>
<?php
    include __DIR__ . '/../BackArrow.php';
    ?>

    <!-- image met tekst, intro -->

    <div class="container">
        <div id="danceIntro">
            <?php echo $dancePage[0]->htmlData;
            ?>
        </div>
    </div>

    <div>
        <h2 class="lineup_h2 d-flex justify-content-center">Lineup</h2>

        <div id="performing_bands_container">
            <?php echo $this->artistService->generateDanceArtistHtml('Martin Garrix'); ?>

            <?php echo $this->artistService->generateDanceArtistHtml('Tiësto'); ?>

            <?php echo $this->artistService->generateDanceArtistHtml('Armin van Buuren'); ?>
        </div>
        <div id="performing_bands_container">
            <?php echo $this->artistService->generateDanceArtistHtml('Hardwell'); ?>

            <?php echo $this->artistService->generateDanceArtistHtml('Nicky Romero'); ?>

            <?php echo $this->artistService->generateDanceArtistHtml('Afrojack'); ?>
        </div>
    </div>
    <h2 class="mt-5 d-flex justify-content-center">Day passes</h2>
    <form method="post" action="/MainDance">
        <div class="container_dayPasses">
            <div class="card" style="width: 20rem;">
                <div class="card-body">
                    <h6 class="card-title">All-access pass (one day)</h6>
                    <h3 class="card-subtitle mb-2" id="card_price">€125,00</h3>
                    <p class="card-text"><i class="far fa-check-square"></i> Access to all performances</p>
                    <p class="card-text"><i class="far fa-check-square"></i> Access on friday</p>
                    <input type="hidden" name="Friday" value="2023-07-28 20:00:00">

                    <button name="danceFridayPass" type="submit" class="btn btn-primary" id="buy_now_button">Buy now</button>
                </div>
            </div>

            <div class="card" style="width: 20rem;">
                <div class="card-body">
                    <h6 class="card-title">All-access pass (one day)</h6>
                    <h3 class="card-subtitle mb-2" id="card_price">€150,00</h3>
                    <p class="card-text"><i class="far fa-check-square"></i> Access to all performances</p>
                    <p class="card-text"><i class="far fa-check-square"></i> Access on saturday or sunday</p>


                    <input checked='checked' type="radio" id="Saturday" name="SaturdaySunday" value="2023-07-29 18:00:00">
                    <label for="Saturday">Saturday</label>
                    <br>
                    <input type="radio" id="Sunday" name="SaturdaySunday" value="2023-07-30 20:00:00">
                    <label for="Sunday">Sunday</label>


                    <button name="danceDayPass" type="submit" class="btn btn-primary" id="buy_now_button">Buy now</button>
                </div>
            </div>

            <div class="card" style="width: 20rem;">
                <div class="card-body">
                    <h6 class="card-title">All-access pass (Three days)</h6>
                    <h3 class="card-subtitle mb-2" id="card_price">€250,00</h3>
                    <p class="card-text"><i class="far fa-check-square"></i> Access to all performances</p>
                    <p class="card-text"><i class="far fa-check-square"></i> Access on all days of the festival!
                    </p>
                    <input type="hidden" name="weekendday" value="2023-07-28 20:00:00">

                    <button name="danceweekendPass" type="submit" class="btn btn-primary" id="buy_now_button">Buy now</button>
                </div>
            </div>
        </div>
    </form>
    <h1 class="mt-5 d-flex justify-content-center">Venue's</h1>
    <div class="dancePageEvents">
        <h1 class="danceEventHeader"></h1>

        <div class="fillDiv"></div>



        <?php
        foreach ($contentEvents as $row) {
        ?>
            <div class="danceEventInformation">
                <?php $dataUri = "data:image/jpg;charset=utf;base64," . base64_encode($row['picture']) ?>
                <img class="venueImage" src="<?php echo $dataUri; ?>" alt="Image is not shown" width="40%">
                <img class="speech" src="/images/General/speechbubble_thingy.png" alt="Image is not shown">
                <div class="speechbubble">
                    <h3> <b>
                            <?php echo $row['name'] ?>
                        </b></h3>
                    <p class="speechbubbleText">
                        <?php echo $row['description'] ?><br><br>
                        <?php echo $row['location'] ?><br>
                    </p>
                    <a href="/MainDance/danceDetail">
                        <form method="POST">
                            <button name="sightInformationBtn" value="<?php echo $row['id']; ?>" class="btn" id="seeMoreButton">
                                See more
                                <div id="seeMoreArrow">
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
        ?>

        <?php
        if (count($contentEvents) % 2 != 0) {
        ?>
            <div class="fillDiv"></div>

        <?php
        }
        ?>
    </div>
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

</html>