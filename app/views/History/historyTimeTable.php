<?php
include __DIR__ . '/../header.php';
?>

<head>
    <link href="../css/History/historyTimeTable.css" rel="stylesheet">
    <link href="../css/timeTable.css" rel="stylesheet">

</head>

<body onload="resetSessionStorage()">
    <p class="title">
        Stroll Through History
    </p>
    <?php
    include __DIR__ . '/../BackArrow.php';
    ?>
    <div class="structureOfHistoryTimeTable">
        <div class="timeTableStructure">
            <div class="timeTableTitle">
                <h1>TimeTable & Tickets</h1>
            </div>
            <?php
            foreach ($historicEventsDates as $row) {
                $date = date_create($row->date);
                ?>
                <form class="formTimeTable" method="POST">
                    <?php if ($_SESSION["TimeTableDate"] == $row->date) {
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
                                <p>Guide</p>
                            </b>
                        </div>
                        <div class="TimeTableHeaderItem">
                            <b>
                                <p>Start <br> Location</p>
                            </b>
                        </div>
                        <div class="TimeTableHeaderItem">
                            <b>
                                <p>Language</p>
                            </b>
                        </div>
                        <div class="TimeTableHeaderItem">
                            <b>
                                <p>Available <br>Tickets</p>
                            </b>
                        </div>
                        <div class="TimeTableHeaderItem">
                            <b>
                                <p>solo ticket <br>(incl. BTW)</p>
                            </b>

                        </div>
                        <div class="TimeTableHeaderItem">
                            <b>
                                <p>Family ticket <br>(incl. BTW)</p>
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
                        foreach ($historicEventsByDate as $row) {
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
                                        <?php echo $row->guide ?>
                                    </p>
                                </div>
                                <div class="TimeTableBodyItem">
                                    <p>
                                        <?php echo $row->location ?>
                                    </p>
                                </div>
                                <div class="TimeTableBodyItem">
                                    <p>
                                        <?php echo $row->language ?>
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
                                <div class="TimeTableBodyItem">
                                    <p> €
                                        <?php
                                        $priceFormat = number_format((float) $row->familyPrice, 2, '.', '');
                                        echo $priceFormat;
                                        ?>,-
                                    </p>
                                </div>
                                <form method="post" class="TimeTableBodyItem" action="/historyTimeTable">
                                    <button id="btn<?php echo $row->eventId ?>" type="button"
                                        onclick="addTicket('<?php echo $row->eventId ?>', 'btn<?php echo $row->eventId ?>', 'div<?php echo $row->eventId ?>')"
                                        class="btnAddTicket" value="<?= $row->eventId ?>">ADD TICKET</button>
                                    <div class="addTicketDiv" id="div<?php echo $row->eventId ?>" style="display: none">
                                        <h5 style="font-size: 0.75rem; margin-top: 5%; color: white">ADD TICKET</h5>
                                        <div class="addTicketInformation">
                                            <div class="ticketInformationStyle">
                                                <input type="number" id="quantity" name="amountSoloTickets" min="0" max="12"
                                                    value="0">
                                                <p>Solo</p>
                                            </div>
                                            <div class="ticketInformationStyle">
                                                <input type="number" id="quantity" name="amountFamilyTickets" min="0"
                                                    max="3" value="0">
                                                <p>Family</p>
                                            </div>
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
                <div style="margin-top: 2.5%">
                    <p>
                        **Participants has to be 12 years old.
                        <br>
                        **No strollers are allowed.
                        <br>
                        **Groups will consist of 12 participants and 1 tour guide.
                        <br>
                        **A family tickets can only consist of max 4 participants.
                    </p>
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

</body>
<script>
    <?php include __DIR__ . "/../timetable/timeTableFunctions.js" ?>
</script>

<?php
include __DIR__ . '/../footer.php';
?>