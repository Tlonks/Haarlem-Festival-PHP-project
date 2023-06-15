<?php
include __DIR__ . '/cmsSidebar.php';
?>
<h1> Orderitem management</h1>

<a href="/cms/orders" class="btn btn-primary"><-</a>

<div class="col-sm-12 py-4">
    <span id="message"></span>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <h2>Order id: <?php echo $orderItems[0]->orderId ?></h2>
                </div>
                <div class="col text-right">

                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="user_table">
                    <thead>
                    <tr>
                        <th scope="col">Orderitem id</th>
                        <th scope="col">Event id</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Subtotal</th>
                        <th scope="col">Type of ticket</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    /** @var array $orderItems */
                    foreach ($orderItems as $order) {
                        ?>
                        <tr id="<?php echo $order->id; ?>">
                            <td> <?= $order->id ?></td>
                            <td> <?= $order->eventId ?> </td>
                            <td> <?= $order->quantityOrder ?> </td>
                            <td>€ <?= $order->subTotal ?> </td>
                            <td> <?= $order->typeOfTicket ?> </td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>

