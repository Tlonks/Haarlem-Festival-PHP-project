<?php
include __DIR__ . '/cmsSidebar.php';

?>

<h1>API key management</h1>

<div class="col-sm-12 py-4">
    <span id="message"></span>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <h2>Keys</h2>
                </div>

            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="event_table">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>First name</th>
                            <th>Last name</th>
                            <th>Role</th>
                            <th>Api key</th>
                            <th>Add key</th>
                            <th>Delete</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        foreach ($model as $row) {
                            ?>
                            <td>
                                <?php echo $row['userId']; ?>
                            </td>
                            <td>
                                <?php echo $row['firstName']; ?>
                            </td>
                            <td>
                                <?php echo $row['lastName']; ?>
                            </td>
                            <td>
                                <?php if ($row['role'] == 1) {
                                    echo "Employee";
                                } else if ($row['role'] == 2) {
                                    echo "User";
                                } else if ($row['role'] == 3) {
                                    echo "Administrator";
                                } else {
                                    echo "guest";
                                }
                                ?>
                            </td>
                            <td>
                                <?php if ($row['apiKey'] != null) {
                                    echo "✓";
                                } else {
                                    echo "X";
                                }
                                ?>
                            </td>
                            <td>
                                <form action="/cms/editKeys" method="post">
                                    <input type="hidden" name="userId" value="<?php echo $row["userId"]; ?>">
                                    <button class="btn btn-success" value="<?php echo $user["userId"]; ?>" type="submit"
                                        name="addButton">
                                        Add key
                                    </button>
                                </form>

                            </td>

                            <td>
                                <form action="/cms/editKeys" method="post">
                                    <input type="hidden" name="userId" value="<?php echo $row["userId"]; ?>">
                                    <button class="btn btn-danger" value="<?= $user["userId"] ?>" type="submit"
                                        name="deleteButton">
                                        Delete
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


</div>