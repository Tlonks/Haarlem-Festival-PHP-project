<?php
include __DIR__ . '/cmsSidebar.php';

?>

<h1>Venue management</h1>

<div class="col-sm-12 py-4">
    <span id="message"></span>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col text-right">
                    <button type="button" name="add_event" id="add_event" class="btn btn-success btn-sm"
                            onclick="openForm()"> + Add Venue
                    </button>

                    <!-- The form -->
                    <div class="form-popup" id="myForm">
                        <form onsubmit="addData()" class="form-container" enctype="multipart/form-data">
                            <h2>Add venue</h2>

                            <label for="nameAdd"><b>Name</b></label>
                            <input id="nameAdd" type="text" placeholder="Name" name="name" required>

                            <label for="descriptionAdd"><b>Description</b></label>
                            <input id="descriptionAdd" type="text" placeholder="Description" name="venue"
                                   required>

                            <label for="locationAdd"><b>Location</b></label>
                            <input id="locationAdd" type="text" placeholder="Location" name="location"
                                   required>

                            <label for=pictureAdd><b>Picture</b> Files < 64mb</label>
                            <input id="pictureAdd" type="file" name="image" accept="image/*">

                            <input id="venueId" type="hidden" name="venueId" value="">
                            <button type="submit" class="btn btn-success btn-sm">Add</button>
                            <button type="button" class="btn btn-danger btn-sm delete" onclick="closeForm()">
                                Cancel
                            </button>
                        </form>
                    </div>

                    <!-- The form -->
                    <div class="form-popup" id="myEditForm">
                        <form onsubmit="postData()" class="form-container" enctype="multipart/form-data">
                            <h2>Edit venue</h2>

                            <label for="name"><b>Name</b></label>
                            <input id="name" type="text" placeholder="Name" name="name" required>

                            <label for="description"><b>Description</b></label>
                            <input id="description" type="text" placeholder="Description" name="venue"
                                   required>

                            <label for="location"><b>Location</b></label>
                            <input id="location" type="text" placeholder="Location" name="location" required>

                            <label for=picture><b>Picture</b> Files < 64mb</label>
                            <input id="picture" type="file" name="image" accept="image/*">

                            <input id="venueId" type="hidden" name="venueId" value="">
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
                        <th>Name</th>
                        <th>Description</th>
                        <th>Location</th>
                        <th>Picture</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    /** @var array $model */
                    foreach ($model as $row) {
                        if (isset($row['picture']))
                            $dataUri = "data:image/jpg;charset=utf;base64," . base64_encode($row['picture'])
                        ?>
                        <tr id="<?php echo $row['id']; ?>">
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['description']; ?></td>
                            <td><?php echo $row['location']; ?></td>
                            <td width="10%"><img src="<?php echo $dataUri; ?>" alt="Image is not shown" width="80%">
                            </td>
                            <td width="10%">
                                <form>
                                    <button type="button" name="edit_event" id="edit_event"
                                            class="btn btn-warning btn-sm edit"
                                            onclick="openEditForm(<?php echo $row["id"]; ?>)"> Edit
                                    </button>
                                    <button type="button" name="delete" class="btn btn-danger btn-sm delete"
                                            value="<?php echo $row['id']; ?>" id="delete"
                                            onclick="deleteEvent(<?php echo $row['id']; ?>)"> Delete
                                    </button>
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
    async function addData() {
        const formData = new FormData();
        formData.append("name", document.getElementById("nameAdd").value);
        formData.append("description", document.getElementById("descriptionAdd").value);
        formData.append("location", document.getElementById("locationAdd").value);
        const file = document.getElementById("pictureAdd").files[0];
        formData.append("picture", file);

        const url = "http://localhost/api/venuecms";

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

    async function deleteEvent(id) {
        await fetch('/api/venuecms?venueId=' + id, {
            method: 'DELETE',
            body: id,
        }).then(res => res.json())
            .catch(error => console.error("Error:", error))
            .then(response => console.log("Success:", response));
        document.getElementById(id).remove();
    }

    async function postData() {
        const formData = new FormData();
        formData.append("name", document.getElementById("name").value);
        formData.append("description", document.getElementById("description").value);
        formData.append("location", document.getElementById("location").value);
        const file = document.getElementById("picture").files[0];
        formData.append("picture", file);
        formData.append("id", document.getElementById("venueId").value);

        const url = "http://localhost/api/venuecms";

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

        let venue = await getVenue(id);

        document.getElementById("name").value = venue.name;
        document.getElementById("description").value = venue.description;
        document.getElementById("location").value = venue.location;
        document.getElementById("venueId").value = id;
    }

    async function getVenue(id) {
        let url = ("http://localhost/api/venuecms?venueId=" + id);
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

