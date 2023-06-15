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
        <div class="confirmationTextBundle">
            <h1 class="confirmationText">The payment failed</h1>
            <h2 class="confirmationText">Please try again by returning to your shopping cart.</h2>
        </div>

        <button onclick="location='/ShoppingCart'" class="btnConfirmationHome">
            Return to shopping cart
        </button>
    </div>
</body>



<?php
include __DIR__ . '/../footer.php';
?>