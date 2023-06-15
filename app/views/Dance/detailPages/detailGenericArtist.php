<?php
include __DIR__ . '/../../header.php';
require_once __DIR__ . "/../../../services/ArtistDetailService.php";
require_once __DIR__ . "/../../../services/JazzEventService.php";


$artistDetailService = new ArtistDetailService();
$generateArtistDetail = $artistDetailService->generateDanceArtistDetailHtml('Artist');
$eventsTable = $artistDetailService->generateArtistDetailTableDance('Artist');
?>
<p class="title">
    Dance
</p>

<link href="/../../css/Main.css" rel="stylesheet">
<link href="/../../css/dance/detailDancePages.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

<title>
    <?php echo $generateArtistDetail->getName() ?>
</title>
</head>

<body>
<?php
    include __DIR__ . '/../../BackArrow.php';
    ?>

    <div class="container">


        <div class="headerDetails">
            <div class="row">
                <div class="col">

                    <img class="HeaderImage" src="<?php echo $generateArtistDetail->getFirstImage() ?>">
                </div>
                <div class="col">
                    <div class="headerText">
                        <h3 class="fw-bold">
                            <?php echo $generateArtistDetail->getName() ?>
                        </h3>

                        <?php echo $generateArtistDetail->getBodyText() ?>

                    </div>
                </div>
            </div>
        </div>

        <div class="mt-5">
            <div class="row">
                <div class="col-sm-4">
                    <img src="<?php echo $generateArtistDetail->getSecondImage() ?>">
                </div>
                <div class="col-sm-8">
                    <table class="scheduled_appearances_Table">
                        <thead>
                            <tr>
                                <th>Venue</th>
                                <th>Day</th>
                                <th>Time</th>
                                <th>Session</th>
                                <th>Single ticket (incl. BTW)</th>
                                <th>Tickets</th>
                            </tr>
                        </thead>


                        <h3 class="fw-bold">Scheduled appearances</h3>
                        <?php
                        if (empty($eventsTable)) {
                            echo "<tr><td colspan='5'>No data found</td></tr>";
                        }
                        foreach ($eventsTable as $row) {
                            $datetime = new DateTime($row->date);
                            $date = $datetime->format('d-m-Y');
                            $time = $datetime->format('H:i');

                            ?>
                            <tr>
                                <td>
                                    <?= $row->location ?>
                                </td>
                                <td>
                                    <?= $date ?>
                                </td>
                                <td>
                                    <?= $time ?>
                                </td>
                                <td>
                                    <?= $row->session ?>
                                </td>
                                <td>
                                    €
                                    <?= $row->price ?>
                                </td>
                                <td><button type="button" class="btn btn-primary buy_button"
                                        onclick="redirectToTimeTable()">Buy tickets</button>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>



                </div>
            </div>
        </div>

        <div class="mt-5">
            <h3 class="fw-bold">Tracks / Albums</h3>
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="image-container">
                            <img src="/../images/Dance/detailPages/Martin_garrix_animals.png" alt="" width="250px">
                            <div class="button-container">
                                <button onclick="playPause()"><i class="fas fa-play"></i> / <i
                                        class="fas fa-pause"></i></button>
                                <button onclick="muteUnmute()"><i class="fas fa-volume-up"></i> / <i
                                        class="fas fa-volume-mute"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="image-container">
                            <img src="/../images/Dance/detailPages/Martin_garrix_aurora.png" alt="" width="250px">
                            <div class="button-container">
                                <button onclick="playPause()"><i class="fas fa-play"></i> / <i
                                        class="fas fa-pause"></i></button>
                                <button onclick="muteUnmute()"><i class="fas fa-volume-up"></i> / <i
                                        class="fas fa-volume-mute"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="image-container">
                            <img src="/../images/Dance/detailPages/Martin_garrix_collection.png" alt="" width="250px">
                            <div class="button-container">
                                <button onclick="playPause()"><i class="fas fa-play"></i> / <i
                                        class="fas fa-pause"></i></button>
                                <button onclick="muteUnmute()"><i class="fas fa-volume-up"></i> / <i
                                        class="fas fa-volume-mute"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="image-container">
                            <img src="/../images/Dance/detailPages/Martin_garrix_lonely.png" alt="" width="250px">
                            <div class="button-container">
                                <button onclick="playPause()"><i class="fas fa-play"></i> / <i
                                        class="fas fa-pause"></i></button>
                                <button onclick="muteUnmute()"><i class="fas fa-volume-up"></i> / <i
                                        class="fas fa-volume-mute"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>




    </div>












</body>

<?php
include __DIR__ . '/../../footer.php';
?>
<script>
    <?php include "detailPages.js" ?>
</script>

</html>