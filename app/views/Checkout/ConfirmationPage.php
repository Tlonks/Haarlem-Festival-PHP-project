<?php

include __DIR__ . '/../header.php';

?>

<!DOCTYPE html>
<link href="/css/confirmationCheckout.css" rel="stylesheet">
<html>

<head>


</head>


<body>
  <p class="title">
    Checkout
  </p>

  <div class="confirmationStucture">
    <img class="confirmationCheckImg" src="/images/Checkout/checkIcon.png" alt="Image is not shown">

    <div class="confirmationTextBundle">
      <h1 class="confirmationText">Thank you for your order!</h1>
      <h2 class="confirmationText">The tickets have been sent to your email address</h2>
    </div>

    <button onclick="location='/'" class="btnConfirmationHome">
      Homepage
    </button>
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