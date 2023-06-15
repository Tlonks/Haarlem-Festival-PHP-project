<?php
include __DIR__ . '/cmsSidebar.php';
?>
<h1> Order management</h1>

<div class="col-sm-12 py-4">
    <span id="message"></span>
    <div class="card">
        <div class="card-header">
            <div class="row">
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="user_table">
                    <thead>
                        <tr>
                            <th scope="col">Order id</th>
                            <th scope="col">User id</th>
                            <th scope="col">Total</th>
                            <th scope="col">Added VAT</th>
                            <th scope="col">Is paid</th>
                            <th scope="col">payment status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        /** @var array $orders */
                        for ($i= 0; $i < count($orders); $i++) { 
                        // foreach ($orders as $order) {
                        ?>
                            <tr id="<?php echo $orders[$i]['id']; ?>">
                                <td> <?= $orders[$i]["id"] ?></td>
                                <td> <?= $orders[$i]["userId"] ?></td>
                                <td> <?= $orders[$i]["totalPrice"] ?> </td>
                                <td> <?= $orders[$i]["addedVAT"] ?> </td>
                                <td id="isPaid<?php echo $orders[$i]['id'] ?>"><?php echo $orders[$i]['isPaid']; ?></td>
                                <td>
                                    <form>
                                        <button type="button" name="edit_event" id="edit_event" class="btn btn-success btn-sm" onclick="setOrderPaid(<?php echo $orders[$i]['id']; ?>, true)"> True </button>
                                        <button type="button" name="delete" class="btn btn-danger btn-sm delete" value="<?php echo $orders[$i]['id']; ?>" id="delete" onclick="setOrderPaid(<?php echo $orders[$i]['id']; ?>, false)"> False </button>
                                    </form>
                                </td>
                                <td>
                                    <form method="POST">
                                        <button type="button" name="edit_user" id="<?php echo $orders[$i]['id']; ?>" class="btn btn-success btn-sm" onclick="openOrder(<?php echo $orders[$i]['id']; ?>)"> Open Order</button>
                                        <button name="pdfDownload" class="btn btn-success btn-sm" value="<?php echo $i; ?>">Download Invoice</button>
                                    </form>
                                </td>
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
<script>
    function setOrderPaid(id, isPaid) {
        let url = "http://localhost/api/orders?id=" + id + "&isPaid=" + isPaid;

        document.getElementById("isPaid" + id).innerText = isPaid;

        fetch(url, {
                method: "PUT",
                headers: {
                    "Content-Type": "application/json"
                }
            }).then(res => res.json())
            .catch(error => console.error("Error:", error))
            .then(response => console.log("Success:", response));
    }

    function openOrder(id) {
        window.location = "http://localhost/cms/order?id=" + id;
    }
</script>
</div>