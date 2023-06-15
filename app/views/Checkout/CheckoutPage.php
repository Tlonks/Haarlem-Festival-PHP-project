<?php
include __DIR__ . '/../header.php';
?>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Checkout</title>
    <link href="/css/Checkout.css" rel="stylesheet">
</head>

<body>
    <p class="title">
        Checkout
    </p>
    <div class="d-flex col-12">
        <div class="container">
            <div class="col-5">
                <div class="row">
                    <div id="title" class="col-12">
                        <h1>Information</h1>
                    </div>
                </div>

                <div>
                    <form action="/Checkout" method="post">
                        <input type="hidden" id="paymentOptionInput" name="paymentOption" value="">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                        </div>
                        <div class="mb-3">
                            <label for="number" class="form-label">Phone number</label>
                            <input type="text" class="form-control" id="number" name="number" placeholder="number" required>
                        </div>

                        <div class="mb-3">
                            <label for="birthdate" class="form-label">Birthdate</label>
                            <input type="date" class="form-control" id="birthdate" name="birthdate" placeholder="birthdate" required>
                        </div>

                        <div class="mb-3">
                            <label for="street" class="form-label">Street address</label>
                            <input type="text" id="street-address" name="street-address" autocomplete="street-address" class="form-control" id="birthdate" name="birthdate" placeholder="address" required>
                        </div>

                        <div class="mb-3">
                            <label for="postal" class="form-label">Postal code</label>
                            <input type="text" id="postal-code" name="postal-code" autocomplete="postal-code" class="form-control" id="postal" name="postal" placeholder="postal" required>
                        </div>

                        <div class="mb-3">
                            <label for="city" class="form-label">City</label>
                            <input type="text" id="city" name="city" autocomplete="city" class="form-control" id="city" name="city" placeholder="city" required>

                        </div>

                        <div class="mb-3">
                            <label for="country" class="form-label">Country</label>
                            <input type="text" id="country" name="country" autocomplete="country" class="form-control" id="country" name="country" placeholder="country" required>
                        </div>
                        <div id="payment" class="col-12">
                            <h1>Payment options</h1>
                        </div>

                        <div id="paymentRow">
                            <label>
                                <input type="radio" id="ideal" name="paymentOption" value="ideal">
                                <img id="paymentOptions" src="/images/Checkout/ideal.png" alt="Option 1">
                            </label>

                            <label>
                                <input type="radio" id="creditcard" name="paymentOption" value="creditcard">
                                <img id="paymentOptions" src="/images/Checkout/mc.jpg" alt="Option 2">
                            </label>
                        </div>


                        <button id="checkoutButton" type="submit" name="placeOrder" class="btn">Place order</button>


                    </form>


                </div>
            </div>

            <div class="tableCheckout col-6">

                <?php if (count($infoShoppingCart) != 0) { ?>
                    <div class="row">
                        <div class="col-12">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Event</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Time</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    for ($i = 0; $i < count($infoShoppingCart); $i++) { ?>
                                        <tr>
                                            <td>
                                            <?php echo $infoShoppingCart[$i]['name'] . $eventInfo[$i]; ?>
                                            </td>
                                            <td>
                                                <?php echo date("d-m-Y", strtotime($infoShoppingCart[$i]['date'])); ?>
                                            </td>
                                            <td>
                                                <?php echo date("H:i", strtotime($infoShoppingCart[$i]['date'])); ?>
                                            </td>
                                            <td>
                                                €
                                                <?php echo $price[$i]; ?>
                                            </td>
                                            <td>
                                                <?php echo $infoShoppingCart[$i]['quantityOrder'] ?>
                                            </td>
                                            <td>
                                                €
                                                <?php echo $infoShoppingCart[$i]['subTotal'] ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div id="total" class="col-9">

                            <p>
                                Total without 9% VAT: €
                                <?php echo number_format(($totalPrice - ($totalPrice * 0.09)), 2, '.', ''); ?>
                            </p>

                            <p>
                                Total: €
                                <?php echo number_format(($totalPrice), 2, '.', ''); ?>
                            </p>

                        </div>
                    </div>
                <?php } else {
                    echo "There are currently no items in the shoppingcart!";
                } ?>
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
<script>
    <?php include "checkout.js" ?>
</script>