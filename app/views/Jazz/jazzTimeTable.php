<?php
include __DIR__ . '/../header.php';
require_once __DIR__ . "/../../services/JazzEventService.php";

$jazzEventService = new jazzEventService();
$tableData = $jazzEventService->getAllJazzEventsByDate("2023-07-26");
?>
<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css"
        integrity="sha384-HzLeBuhoNPvSl5KYnjx0BT+WB0QEEqLprO+NBkkk5gbc67FTaL7XIGa2w1L0Xbgc" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Sen' rel='stylesheet'>
    <link href="../css/jazzTimeTable.css" rel="stylesheet">
    <link href="../css/timeTable.css" rel="stylesheet">

    <title>Haarlem jazz</title>
</head>

<body onload="resetSessionStorage()">

    <p class="title">
        Haarlem jazz
    </p>
    <?php
  include __DIR__ . '/../BackArrow.php';
  ?>
    <div class="structureOfJazzTimeTable">
        <div class="timeTableStructure">
            <div class="timeTableTitle">
                <h1>TimeTable & Tickets</h1>
            </div>
            <?php
            foreach ($dateOfAllEvents as $row) {
                $date = date_create($row->date);
                ?>
                <form class="formTimeTable" method="POST">
                    <?php if ($_SESSION["TimeTableDateJazz"] == $row->date) {
                        ?>
                        <button onclick="resetSessionStorage()" class="btnTimeTableDateRed" name="btnTimeTableDate"
                            value="<?php echo $row->date ?>"><?php echo date_format($date, "l<\b\\r>d-F o") ?></button>

                        <?php
                    } else {
                        ?>
                        <button onclick="resetSessionStorage()" class="btnTimeTableDate" name="btnTimeTableDate"
                            value="<?php echo $row->date ?>"><?php echo date_format($date, "l<\b\\r>d-F o") ?></button>
                        <?php
                    } ?>

                </form>
                <?php
            }
            ?>
            <div class="timeTableColumns">
                <div class="TimeTable">
                    <div class="TimeTableHeader">
                        <div class="TimeTableHeaderItem">
                            <b>
                                <p>Time</p>
                            </b>
                        </div>
                        <div class="TimeTableHeaderItem">
                            <b>
                                <p>Artist</p>
                            </b>
                        </div>
                        <div class="TimeTableHeaderItem">
                            <b>
                                <p>Location</p>
                            </b>
                        </div>
                        <div class="TimeTableHeaderItem">
                            <b>
                                <p>Hall</p>
                            </b>
                        </div>
                        <div class="TimeTableHeaderItem">
                            <b>
                                <p>Available</p>
                                <p>Tickets</p>
                            </b>
                        </div>
                        <div class="TimeTableHeaderItem">
                            <b>
                                <p>solo ticket <br>(incl. BTW)</p>
                            </b>
                        </div>
                        <div class="TimeTableHeaderItem">
                            <b>
                                <p>Tickets</p>
                            </b>
                        </div>
                        <div class="TimeTableHeaderItem">
                            <b>
                            </b>
                        </div>
                    </div>

                    <div id="historyScrollBar" class="scrollBar">
                        <?php
                        foreach ($allEventsOfJazzByDate as $row) {
                            ?>
                            <div class="TimeTableBody" id="<?php echo $row->eventId ?>">
                                <div class="TimeTableBodyItem">
                                    <p>
                                        <?php $date = date_create($row->date);
                                        echo date_format($date, "H:i") ?>
                                    </p>
                                </div>
                                <div class="TimeTableBodyItem">
                                    <p>
                                        <?php echo $row->name ?>
                                    </p>
                                </div>
                                <div class="TimeTableBodyItem">
                                    <p>
                                        <?php echo $row->location ?>
                                    </p>
                                </div>
                                <div class="TimeTableBodyItem">
                                    <p>
                                        <?php echo $row->hall ?>
                                    </p>
                                </div>
                                <div class="TimeTableBodyItem">
                                    <p>
                                        <?php echo $row->quantity ?>
                                    </p>
                                </div>
                                <div class="TimeTableBodyItem">
                                    <p> €
                                        <?php
                                        $priceFormat = number_format((float) $row->price, 2, '.', '');
                                        echo $priceFormat;
                                        ?>,-
                                    </p>
                                </div>
                                <form method="post" class="TimeTableBodyItem" action="/MainJazz/jazzTimeTable">
                                    <button id="btn<?php echo $row->eventId ?>" type="button" 
                                            <?php if (date('d', strtotime($row->date)) == 29) echo 'disabled' ?>
                                        onclick="addTicket('<?php echo $row->eventId ?>', 'btn<?php echo $row->eventId ?>', 'div<?php echo $row->eventId ?>')"
                                        class="btnAddTicket" value="<?= $row->eventId ?>">
                                        <?php
                                        if ($row->price == 0) {
                                            echo 'Free Access';
                                        } else {
                                            echo 'ADD TICKET';
                                        }
                                        ?>
                                    </button>
                                    <div class="addTicketDiv" id="div<?php echo $row->eventId ?>" style="display: none">
                                        <h5 style="font-size: 0.75rem; margin-top: 5%; color: white">ADD TICKET</h5>
                                        <div class="addTicketInformation" style="padding-top: 10%">
                                            <div class="ticketInformationStyle">
                                                <input type="number" id="quantity" name="amountSoloTickets" min="0" max="12"
                                                    value="1">
                                                <p>Solo</p>
                                            </div>
                                            <input type="hidden" id="quantity" name="amountFamilyTickets" min="0" max="12"
                                                value="0">

                                            <button onclick="resetSessionStorage()" value="<?php echo $row->eventId ?>" name="btnAddTicket"
                                                class="btnTicketInformationStyle">Add Tickets</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <?php
                        }
                        ?>
                    </div>
                </div>
                <?php if (isset($popUp)) {
                    include __DIR__ . "/../timetable/timeTablePopUp.php";
                    $_SESSION['showPopUpMessage'] = NULL;
                    $popUp = NULL;
                }
                ?>
            </div>

        </div>
    </div>

    <script>
        <?php include __DIR__ . "/../timetable/timeTableFunctions.js" ?>
    </script>



</html>
<?php
include __DIR__ . '/../footer.php';
?>