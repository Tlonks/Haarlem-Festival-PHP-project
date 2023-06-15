<?php
include __DIR__ . '/cmsSidebar.php';

?>
<h1> Reservation management</h1>

<div class="col-sm-12 py-4">
    <span id="message"></span>
    <div class="card">
        <div class="card-header">
            <div class="row">
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="event_table">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Date</th>
                        <th>Special requests</th>
                        <th>Amount of People</th>
                        <th>Restaurant</th>
                        <th>Is canceled</th>
                        <th>Cancel</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    /** @var array $model */
                    foreach ($model as $row) {
                        ?>
                        <tr id="<?php echo $row['id']; ?>">
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['date']; ?></td>
                            <td><?php echo $row['specialRequests']; ?></td>
                            <td><?php echo $row['amountOfPeople']; ?></td>
                            <td><?php echo $row['restaurant']; ?></td>
                            <td id="IsCancelled<?php echo $row["id"]?>"><?php echo $row['canceled']; ?></td>
                            <td>
                                <form>
                                    <button type="button" name="edit_event" id="edit_event"
                                            class="btn btn-success btn-sm"
                                            onclick="cancelReservation(<?php echo $row['id']; ?>, true)"> True
                                    </button>
                                    <button type="button" name="delete" class="btn btn-danger btn-sm delete"
                                            value="<?php echo $row['id']; ?>" id="delete"
                                            onclick="cancelReservation(<?php echo $row['id']; ?>, false)"> False
                                    </button>
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
    function cancelReservation(id, isCanceled) {
        let url = "http://localhost/api/reservationcms?id=" + id + "&isCanceled=" + isCanceled;

        document.getElementById("IsCancelled" + id).innerText = isCanceled;

        fetch(url, {
            method: "PUT",
            headers: {
                "Content-Type": "application/json"
            }
        }).then(res => res.json())
            .catch(error => console.error("Error:", error))
            .then(response => console.log("Success:", response));
    }
</script>
</div>



