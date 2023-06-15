<link href="../css/timeTablePopUp.css" rel="stylesheet">


<div id="popUpMessage" class="popup">
    <div class="popupContent">
        <h2><?php echo $_SESSION["showPopUpMessage"]; ?></h2>
        <button class="btnClosePopUp" onclick="closePopUpMessage()">Okay</button>
    </div>
</div>

<script>
    <?php include "timeTableFunctions.js" ?>
</script>