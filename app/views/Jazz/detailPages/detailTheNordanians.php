<?php
include __DIR__ . '/../../header.php';
require_once __DIR__ . "/../../../services/ArtistDetailService.php";
require_once __DIR__ . "/../../../services/JazzEventService.php";

$artistDetailService = new ArtistDetailService();
$generateArtistDetail = $artistDetailService->generateArtistDetailHtml('The Nordanians');
$eventsTable = $artistDetailService->generateArtistDetailTable('The Nordanians');



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/detailPageJazz.css" rel="stylesheet">

    <title>
        <?php echo $generateArtistDetail->getTitle() ?>
    </title>
</head>

<body>
<p class="title">
    Haarlem jazz
</p>
<?php
    include __DIR__ . '/../../BackArrow.php';
    ?>
    <div class="container">
        <h1 id="Artist_Name">
            <?php echo $generateArtistDetail->getTitle() ?>
        </h1>

        <img class="HeaderImage" src="<?php echo $generateArtistDetail->getFirstImage() ?>">

        <div class="row">
            <h4 class="carreer_title">Carreer Highlights</h4>
            <div class="card">
                <div class="card-body">
                    <p class="card-text">
                        <?php echo $generateArtistDetail->getHeadText() ?>
                    </p>
                </div>
            </div>

            <img class="middle-image" src="<?php echo $generateArtistDetail->getSecondImage() ?>">
        </div>

        <div class="container_tracks">
            <h4 class="tracks_intro">Some tracks of
                <?php echo $generateArtistDetail->getTitle() ?> from one of their albums.
            </h4>
            <div class="row">
                <div class="iframe-container">
                    <iframe class="tracks" width="260" height="60"
                        src="https://www.muziekweb.nl/Embed/JE42158-0001/Choro-cubano?theme=static&color=dark"
                        frameborder="no" scrolling="no" allowtransparency="true"></iframe>
                </div>
                <div class="iframe-container">
                    <iframe class="tracks" width="260" height="60"
                        src="https://www.muziekweb.nl/Embed/JE42158-0002/North-brown?theme=static&color=dark"
                        frameborder="no" scrolling="no" allowtransparency="true"></iframe>
                </div>
            </div>
            <img src="../images/Jazz/album/albumLogo.png" width="250" height="250" alt="">
            <div class="row">
                <div class="iframe-container">
                    <div class="iframe-container">
                        <iframe class="tracks" width="260" height="60"
                            src="https://www.muziekweb.nl/Embed/JE42158-0005/Doe-open?theme=static&color=dark"
                            frameborder="no" scrolling="no" allowtransparency="true"></iframe>
                    </div>
                    <div class="iframe-container">
                        <iframe class="tracks" width="260" height="60"
                            src="https://www.muziekweb.nl/Embed/JE42158-0012/Kat?theme=static&color=dark"
                            frameborder="no" scrolling="no" allowtransparency="true"></iframe>
                    </div>
                </div>
            </div>
        </div>

        <h4 class="scheduled_title">Scheduled appearances</h4>

        <!-- tijdelijk hard coded info -->
        <table class="scheduled_appearances_Table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Location</th>
                    <th>Hall</th>
                    <th>Time</th>
                    <th>Single ticket (incl. BTW)</th>
                    <th>Tickets</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (empty($eventsTable)) {
                    echo "<tr><td colspan='5'>No data found</td></tr>";
                }
                foreach ($eventsTable as $row) {
                    $datetime = new DateTime($row->date);
                    $endTime = new DateTime($row->endTime);
                    $date = $datetime->format('d-m-Y');
                    $time = $datetime->format('H:i');
                    $endTime = $endTime->format('H:i');
                    ?>
                    <tr>
                        <td>
                            <?= $date ?>
                        </td>
                        <td>
                            <?= $row->location ?>
                        </td>
                        <td>
                            <?= $row->hall ?>
                        </td>
                        <td>
                            <?= $time ?> -
                            <?= $endTime ?>
                        </td>
                        <td>
                            €
                            <?= $row->price ?>
                        </td>
                        <td>
                            <?php if ($date == '29-07-2023') {
                                echo '<button type="button" class="btn btn-primary free_button" disabled>Free Access</button>';
                            } else {
                                echo '<button type="button" class="btn btn-primary buy_button" onclick="redirectToTimeTable()">Buy tickets</button>';
                            }
                            ?>
                        </td>
                        </td>
                    </tr>
                    <?php
                }
                ?>
        </table>




    </div>





</body>


</html>
<script>
    <?php include "detailPagesJazz.js" ?>
</script>
<?php
include __DIR__ . '/../../footer.php';
?>