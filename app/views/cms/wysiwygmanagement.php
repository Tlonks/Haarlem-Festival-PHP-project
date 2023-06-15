<?php
include __DIR__ . '/cmsSidebar.php';

?>

<h1>Wysiwyg management</h1>

<div class="col-sm-12 py-4">
    <span id="message"></span>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col text-right">
                    <button type="button" name="add_event" id="add_event" class="btn btn-success btn-sm"
                            onclick="openForm()"> + Add Page
                    </button>
                    <!-- The form -->
                    <div class="form-popup" id="myForm">
                        <form method="post" class="form-container">
                            <h2>Add page</h2>

                            <label for="title"><b>Title</b></label>
                            <input type="text" placeholder="Enter Title" name="title" id="title" required>

                            <label for="category"><b>Category</b></label>
                            <input type="text" placeholder="Enter Category" name="category" id="category" required>

                            <input id="pageId" type="hidden" name="pageId" value="">
                            <button type="submit" class="btn btn-success btn-sm">Add</button>
                            <button type="button" class="btn btn-danger btn-sm delete" onclick="closeForm()">
                                Cancel
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="event_table">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    /** @var array $model */
                    foreach ($model as $row) { ?>
                        <tr id="<?php echo $row['id']; ?>">
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['title']; ?></td>
                            <td><?php echo $row['category']; ?></td>
                            </td>
                            <td width="10%">
                                <form>
                                    <button type="button" name="edit_event" id="edit_event"
                                            class="btn btn-warning btn-sm edit"
                                            onclick="openWysiwyg(<?php echo $row["id"]; ?>)"> Edit
                                    </button>
                                    <?php if ($row['id'] > 6){ ?>
                                    <button type="button" name="delete" class="btn btn-danger btn-sm delete"
                                            value="<?php echo $row['id']; ?>" id="delete"
                                            onclick="deletePage(<?php echo $row['id']; ?>)"> Delete
                                    </button> <?php }?>
                                </form>
                            </td>
                        </tr>
                        <?php
                        $dataUri = "";
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    function deletePage(id){
        window.location.href = "/cms/wysiwygmanagement?deleteId=" + id;
    }

    function openForm() {
        document.getElementById("myForm").style.display = "block";
    }

    function closeForm() {
        document.getElementById("myForm").style.display = "none";
    }

    function openWysiwyg(id) {
        window.location.href = "/cms/wysiwyg?id=" + id;
    }
</script>
</div>

