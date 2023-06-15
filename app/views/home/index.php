<head>
    <link href="../css/HomePage/homePage.css" rel="stylesheet">
    <link href="../css/timeTable.css" rel="stylesheet">


</head>

<body onload="resetSessionStorage()">
    <?php

    include __DIR__ . '/../header.php';
    ?>

    <p class="title">
        The Festival
    </p>

    <div class="homePageStructure">
        <?php
        echo $homePage[0]->htmlData;
        ?>
        <div class="mainPageEvents">
            <h1 class="eventHeader">Events</h1>

            <div class="fillDiv"></div>



            <?php
            foreach ($contentEvents as $row) {
            ?>
                <div class="mainpageEventInformation">
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
                        <a>
                            <form method="POST">
                                <button name="sightInformationBtn" value="<?php echo $row->nextPage; ?>" class="btn" id="seeMoreButton">
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

        <div class="mainPageScheduleOfEvents">
            <div class="timeTableStructure">
                <div class="timeTableTitle">
                    <h1>TimeTable & Tickets</h1>
                </div>
                <div class="timeTableDateStructure">
                    <div class="timeTableDateInformationStructure">
                        <?php
                        foreach ($allHistoricEventDates as $row) {
                            $date = date_create($row->date);
                        ?>
                            <form class="formTimeTable" method="POST" action="/">
                                <?php if ($_SESSION["TimeTableDate"] == $row->date) {
                                ?>
                                    <button onclick="resetSessionStorage()" class="btnTimeTableDateRed" name="btnTimeTableDate" value="<?php echo $row->date ?>"><?php echo date_format($date, "l<\b\\r>d-F o") ?></button>
                                <?php
                                } else {
                                ?>

                                    <button onclick="resetSessionStorage()" class="btnTimeTableDate" name="btnTimeTableDate" value="<?php echo $row->date ?>"><?php echo date_format($date, "l<\b\\r>d-F o") ?></button>

                                <?php
                                } ?>

                            </form>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="btnTimeTableInformation">
                        <p>A stroll through history</p>
                    </div>
                </div>
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
                                    <form method="post" class="TimeTableBodyItem">
                                        <button id="btn<?php echo $row->eventId ?>" type="button" onclick="addTicket('<?php echo $row->eventId ?>', 'btn<?php echo $row->eventId ?>', 'div<?php echo $row->eventId ?>')" class="btnAddTicket" value="<?= $row->eventId ?>">ADD TICKET</button>
                                        <div class="addTicketDiv" id="div<?php echo $row->eventId ?>" style="display: none">
                                            <h5 style="font-size: 0.75rem; margin-top: 5%; color: white">ADD TICKET</h5>
                                            <div class="addTicketInformation">
                                                <div class="ticketInformationStyle">
                                                    <input type="number" id="quantity" name="amountSoloTickets" min="0" max="12" value="0">
                                                    <p>Solo</p>
                                                </div>
                                                <div class="ticketInformationStyle">
                                                    <input type="number" id="quantity" name="amountFamilyTickets" min="0" max="3" value="0">
                                                    <p>Family</p>
                                                </div>
                                                <button onclick="resetSessionStorage()" value="<?php echo $row->eventId ?>" name="btnAddTicket" class="btnTicketInformationStyle">Add
                                                    Tickets</button>
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

            </div>

        </div>

        <div class="mainPageScheduleOfEvents">
            <div class="timeTableStructure">
                <div class="timeTableDateStructure">
                    <div class="timeTableDateInformationStructure">
                        <?php
                        foreach ($allDanceAndJazzEventDates as $row) {
                            $date = date_create($row->date);
                        ?>
                            <form class="formTimeTable" method="POST">

                                <?php if ($_SESSION["TimeTableDateDanceJazz"] == $row->date) {
                                ?>
                                    <button onclick="resetSessionStorage()" class="btnTimeTableDateRed" name="btnTimeTableDateDanceJazz" value="<?php echo $row->date ?>"><?php echo date_format($date, "l<\b\\r>d-F o") ?></button>
                                <?php
                                } else {
                                ?>
                                    <button onclick="resetSessionStorage()" class="btnTimeTableDate" name="btnTimeTableDateDanceJazz" value="<?php echo $row->date ?>"><?php echo date_format($date, "l<\b\\r>d-F o") ?></button>


                                <?php
                                } ?>

                            </form>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="btnTimeTableInformation">
                        <p>Dance And Jazz</p>
                    </div>
                </div>


                <div class="timeTableColumns">
                    <div class="TimeTable">
                        <div id="TimeTableHeaderJazzDance" class="TimeTableHeader">

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
                                    <p>Event</p>
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
                        <div class="scrollBar">
                            <?php
                            foreach ($danceEventsByDate as $row) {
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
                                            <?php echo "$row->artist" ?>
                                        </p>
                                    </div>
                                    <div class="TimeTableBodyItem">
                                        <p>
                                            <?php echo $row->location ?>
                                        </p>
                                    </div>
                                    <div class="TimeTableBodyItem">
                                        <p>
                                            <?php echo "-" ?>
                                        </p>
                                    </div>
                                    <div class="TimeTableBodyItem">
                                        <p>
                                            <?php echo $row->name ?>
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
                                    <form method="post" class="TimeTableBodyItem" action="/">
                                        <button id="btn<?php echo $row->eventId ?>" type="button" onclick="addTicket('<?php echo $row->eventId ?>', 'btn<?php echo $row->eventId ?>', 'div<?php echo $row->eventId ?>')" class="btnAddTicket" value="<?= $row->eventId ?>">ADD TICKET</button>
                                        <div class="addTicketDiv" id="div<?php echo $row->eventId ?>" style="display: none">
                                            <h5 style="font-size: 0.75rem; margin-top: 5%; color: white">ADD TICKET</h5>
                                            <div class="addTicketInformation" style="padding-top: 10%">
                                                <div class="ticketInformationStyle">
                                                    <input type="number" id="quantity" name="amountSoloTickets" min="0" max="12" value="0">
                                                    <p>Solo</p>
                                                </div>
                                                <input type="hidden" id="quantity" name="amountFamilyTickets" min="0" max="12" value="0">

                                                <button onclick="resetSessionStorage()" value="<?php echo $row->eventId ?>" name="btnAddTicket" class="btnTicketInformationStyle">Add
                                                    Tickets</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                            <?php
                            }
                            ?>





                            <?php
                            foreach ($jazzEventsByDate as $row) {
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
                                            <?php echo "-" ?>
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
                                            <?php echo $row->name ?>
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
                                    <form method="post" class="TimeTableBodyItem" action="/">
                                        <button id="btn<?php echo $row->eventId ?>" type="button" onclick="addTicket('<?php echo $row->eventId ?>', 'btn<?php echo $row->eventId ?>', 'div<?php echo $row->eventId ?>')" class="btnAddTicket" value="<?= $row->eventId ?>">ADD TICKET</button>
                                        <div class="addTicketDiv" id="div<?php echo $row->eventId ?>" style="display: none">
                                            <h5 style="font-size: 0.75rem; margin-top: 5%; color: white">ADD TICKET</h5>
                                            <div class="addTicketInformation" style="padding-top: 10%">
                                                <div class="ticketInformationStyle">
                                                    <input type="number" id="quantity" name="amountSoloTickets" min="0" max="12" value="0">
                                                    <p>Solo Ticket</p>
                                                </div>
                                                <input type="hidden" id="quantity" name="amountFamilyTickets" min="0" max="12" value="0">

                                                <button onclick="resetSessionStorage()" value="<?php echo $row->eventId ?>" name="btnAddTicket" class="btnTicketInformationStyle">Add
                                                    Tickets</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                            <?php
                            }
                            ?>
                        </div>
                    </div>
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




    <div class="mainPageStartingLocation">
        <h1 class="eventHeader">Starting locations</h1>
        <div class="fillDiv"></div>
        <div class="startingLocations">
            <?php
            foreach ($startingLocations as $row) {
            ?>
                <div class="singleLocation">
                    <div class="startingLocationHeader">
                        <h2>
                            <?php echo $row->title ?>
                        </h2>
                    </div>
                    <div class="startingLocationInformation">
                        <div class="startingLocationLeftSide">
                            <p>
                                <?php echo $row->name ?>
                            </p>
                            <p>
                                <?php echo $row->location ?>
                            </p>
                        </div>
                        <div class="startingLocationRightSide">
                            <p>The experience is available between
                                <br>
                                <?php
                                $date = date_create($row->beginDate);
                                echo date_format($date, "j F") ?>
                                -
                                <?php $date = date_create($row->endDate);
                                echo date_format($date, "j F") ?>
                            </p>
                            <p>
                                <?php echo $row->time ?>
                            </p>
                        </div>
                    </div>

                </div>


            <?php
            }
            ?>
        </div>
    </div>

    <div class="mt-4">
        <?php
        include_once __DIR__ . '/../InstagramFeed.php';
        ?>
    </div>

    <div class="mainPageMapOfEvents">
        <h1 class="eventHeader">Map of the events</h1>
        <div class="fillDiv"></div>

        <div class="container">
            <img class="imageMapOfHaarlem" src="/images/homePage/MapOfHaarlem/City of Haarlem.png" alt="Image is not shown" usemap="#mapOfHaarlem">
            <map id="mapOfHaarlem" name="mapOfHaarlem">
                <!-- coords are left - top , left top -->
                <area shape="rect" coords="900,150,950,200" alt="molenAdriaan">
            </map>
        </div>
    </div>

    <div class="contentCardsFooterStructure">
        <?php foreach ($footerContentCards as $row) {
        ?>

            <div class="footerContentCard">
                <?php $dataUri = "data:image/jpg;charset=utf;base64," . base64_encode($row->image) ?>
                <img src="<?php echo $dataUri; ?>" alt="Image is not shown">
                <h3>
                    <?php echo $row->title ?>
                </h3>
                <p>
                    <?php echo $row->information ?>
                </p>
                <form class="formTimeTableDate" method="POST">

                    <button class="sightInformationBtn" name="sightInformationBtn" value="<?php echo $row->nextPage; ?>">Read more</button>

                </form>

            </div>
            </a>

        <?php
        } ?>
    </div>
    </div>



    <?php
    include __DIR__ . '/../footer.php';
    ?>
</body>
<script>
    <?php include __DIR__ . "/../timetable/timeTableFunctions.js" ?>
</script>