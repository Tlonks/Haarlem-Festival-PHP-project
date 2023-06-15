<?php
include __DIR__ . '/cmsSidebar.php';

?>

<h1>CMS</h1>

<div class="col-sm-12 py-4">
    <span id="message"></span>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <h2>Event Management</h2>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="event_table">
                    <thead>
                    <tr>
                        <th>Event id</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Date</th>
                        <th>Price</th>
                        <th>Quantity left</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    /** @var array $model */
                    foreach ($model as $row) {
                        ?>
                        <tr id="<?php echo $row['eventId']; ?>">
                            <td><?php echo $row['eventId']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['category']; ?></td>
                            <td><?php echo $row['date']; ?></td>
                            <td><?php echo $row['price']; ?></td>
                            <td><?php echo $row['quantity']; ?></td>
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