<?php
include __DIR__ . '/cmsSidebar.php';

?>
<h1>History sights management</h1>

<div class="col-sm-12 py-4">
    <span id="message"></span>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col text-right">
                    <button type="button" name="add_event" id="add_event" class="btn btn-success btn-sm"
                            onclick="openForm()"> + Add Sight
                    </button>

                    <!-- The form -->
                    <div class="form-popup" id="myForm">
                        <form onsubmit="addData()" class="form-container" enctype="multipart/form-data">
                            <h2>Add sight</h2>

                            <label for="titleAdd"><b>Title</b></label>
                            <input id="titleAdd" type="text" placeholder="Title" name="title" required>

                            <label for="informationAdd"><b>Information</b></label>
                            <input id="informationAdd" type="text" placeholder="Information" name="information" required>

                            <label for=pictureAdd><b>Picture</b> Files < 64mb</label>
                            <input id="pictureAdd" type="file" accept="image/*" name="image">

                            <input id="contentCardIdAdd" type="hidden" name="contentCardId" value="">
                            <button type="submit" class="btn btn-success btn-sm">Add</button>
                            <button type="button" class="btn btn-danger btn-sm delete" onclick="closeForm()">
                                Cancel
                            </button>
                        </form>
                    </div>

                    <!-- The form -->
                    <div class="form-popup" id="myEditForm">
                        <form onsubmit="postData()" class="form-container">
                            <h2>Edit sight</h2>

                            <label for="title"><b>Title</b></label>
                            <input id="title" type="text" placeholder="Title" name="title" required>

                            <label for="information"><b>Information</b></label>
                            <input id="information" type="text" placeholder="Information" name="information" required>

                            <label for=picture><b>Picture</b> Files < 64mb</label>
                            <input id="picture" type="file" accept="image/*" name="image">

                            <input id="contentCardId" type="hidden" name="contentCardId" value="">
                            <button type="submit" class="btn btn-success btn-sm">Edit</button>
                            <button type="button" class="btn btn-danger btn-sm delete" onclick="closeEditForm()">
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
                        <th>Information</th>
                        <th>Picture</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    /** @var array $model */
                    foreach ($model as $row) {
                        $dataUri = "data:image/jpg;charset=utf;base64," . base64_encode($row->image);
                        ?>
                        <tr id="<?php echo $row->id; ?>">
                            <td><?php echo $row->id; ?></td>
                            <td><?php echo $row->title; ?></td>
                            <td><?php echo $row->information; ?></td>
                            <td width="10%"><img src="<?php echo $dataUri; ?>" alt="Image is not shown" width="80%">
                            </td>
                            <td>
                                <form>
                                    <button type="button" name="edit_event" id="edit_event"
                                            class="btn btn-warning btn-sm edit"
                                            onclick="openEditForm(<?php echo $row->id; ?>)"> Edit
                                    </button>
                                    <button type="button" name="delete" class="btn btn-danger btn-sm delete"
                                            value="<?php echo $row->id; ?>" id="delete"
                                            onclick="deleteSight(<?php echo $row->id; ?>)"> Delete
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
    async function addData() {
        const formData = new FormData();
        formData.append("title", document.getElementById("titleAdd").value);
        formData.append("information", document.getElementById("informationAdd").value);
        const file = document.getElementById("pictureAdd").files[0];
        formData.append("picture", file);

        const url = "http://localhost/api/historysightscms";

        try {
            const response = await fetch(url, {
                method: "POST",
                body: formData,
            });

            if (response.ok) {
                const result = await response.json();
                console.log("Success:", result);
            } else {
                console.error("Error:", response.status);
            }
        } catch (e) {
            console.log(e);
        }
    }

    async function deleteSight(id) {
        // Send a DELETE request to the server with the Event ID
        await fetch('/api/historysightscms?sightId=' + id, {
            method: 'DELETE',
            body: id,
        }).then(res => res.json())
            .catch(error => console.error("Error:", error))
            .then(response => console.log("Success:", response));
        document.getElementById(id).remove();
    }

    async function postData() {
        const formData = new FormData();
        // Get the file from the input element
        const file = document.getElementById("picture").files[0];
        formData.append('picture', file);

        // Add the name to the FormData object
        formData.append('title', document.getElementById("title").value);
        formData.append('id', document.getElementById("contentCardId").value);
        formData.append('information', document.getElementById("information").value);

        const url = "http://localhost/api/historysightscms";

        try {
            const response = await fetch(url, {
                method: "POST",
                body: formData,
            });

            if (response.ok) {
                const result = await response.json();
                console.log("Success:", result);
            } else {
                console.error("Error:", response.status);
            }
        } catch (e) {
            console.log(e);
        }
    }

    async function openEditForm(id) {
        document.getElementById("myEditForm").style.display = "block";

        let sight = await getSight(id);
        console.log(sight);

        document.getElementById('title').value = sight.title;
        document.getElementById('information').value = sight.information;
        document.getElementById('contentCardId').value = id;
    }

    async function getSight(id) {

        let url = ("http://localhost/api/historysightscms?sightId=" + id);
        try {
            let res = await fetch(url);
            console.log(res);
            return await res.json();
        } catch (error) {
            console.log(error);
        }
    }


    function closeEditForm() {
        document.getElementById("myEditForm").style.display = "none";
    }

    function openForm() {
        document.getElementById("myForm").style.display = "block";
    }

    function closeForm() {
        document.getElementById("myForm").style.display = "none";
    }
</script>
</div>




