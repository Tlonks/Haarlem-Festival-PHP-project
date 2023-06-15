<?php
include __DIR__ . '/../header.php';
?>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Shopping cart</title>
    <link href="/css/ShoppingCart.css" rel="stylesheet">

</head>

<body>
    <p class="title">
        Shopping cart
    </p>
    <br><br>
    <form method="POST">

        <div class="container">
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
                                <?php for ($i = 0; $i < count($infoShoppingCart); $i++) { ?>
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
                                            €  <?php echo $price[$i]; ?>
                                        </td>
                                        <td>
                                            <?php echo $infoShoppingCart[$i]['quantityOrder'] ?>
                                        </td>
                                        <td>
                                            € <?php echo $infoShoppingCart[$i]['subTotal'] ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php } else {
                echo "There are currently no items in the shoppingcart!";
            } ?>
        </div>
    </form>

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