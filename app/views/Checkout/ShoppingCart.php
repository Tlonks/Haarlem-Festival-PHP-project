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

    <div class="container">
        <?php if (count($infoShoppingCart) != 0) { ?>
            <div class="row">
                <div class="col-12">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Event</th>
                                <th width="150px" scope="col">Date</th>
                                <th width="120px" scope="col">Time</th>
                                <th width="120px" scope="col">Price</th>
                                <th width="120px" scope="col">Amount</th>
                                <th width="150px" scope="col">Total</th>
                                <th width="50px" scope="col"></th>
                                <th width="50px" scope="col"></th>
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
                                    <td>
                                        <form method="POST">
                                            <button class="btn" name="btnRemove" value="<?php echo $i; ?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="grey" cla∂ss="bi bi-dash-circle-fill" viewBox="0 0 16 16">
                                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1h-7z" />
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                    <td>
                                        <form method="POST">
                                            <button class="btn" name="btnAdd" value="<?php echo $i; ?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="grey" class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z" />
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                    
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="d-flex">
                    <form method="POST">
                        <button class="btn btnCheckOut" name="btnCheckOut"><b>Checkout</b></button>
                    </form>
                    <button class="btn btnCheckOut" id="btnShare">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-share-fill" viewBox="0 0 16 16">
                            <path d="M11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.499 2.499 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5z" />
                        </svg>
                    </button>
                    <?php
                    $totalPrice = 0;
                    for ($i = 0; $i < count($infoShoppingCart); $i++) {
                        $totalPrice += $infoShoppingCart[$i]['subTotal'];
                    }
                    ?>

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
    
    <?php if (isset($popUp)) {
        include __DIR__ . "/../timetable/timeTablePopUp.php";
        $_SESSION['showPopUpMessage'] = NULL;
        $popUp = NULL;
    }
    ?>

</body>

<script>
    <?php include "shoppingCartShare.js" ?>
</script>

<?php
include __DIR__ . '/../footer.php';
?>