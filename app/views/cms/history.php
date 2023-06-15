<?php
include __DIR__ . '/cmsSidebar.php';

?>

<h1>History event management</h1>

<div class="col-sm-12 py-4">
    <span id="message"></span>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col text-right">
                    <button type="button" name="add_event" id="add_event" class="btn btn-success btn-sm"
                            onclick="openForm()"> + Add Event
                    </button>

                    <!-- The form -->
                    <div class="form-popup" id="myForm">
                        <form onsubmit="addData()" class="form-container">
                            <h2>Add event</h2>

                            <label for="nameAdd"><b>Name</b></label>
                            <input id="nameAdd" type="text" placeholder="Name" name="name" required>

                            <label for="dateAdd"><b>Date</b></label>
                            <input id="dateAdd" type="datetime-local" name="date" required>

                            <label for="priceAdd"><b>Price</b></label>
                            <input id="priceAdd" step="0.5" type="number" placeholder="Price" name="price" required>

                            <label for="quantityAdd"><b>Quantity</b></label>
                            <input id="quantityAdd" type="number" placeholder="Quantity" name="quantity" required>

                            <label for="locationAdd"><b>Location</b></label>
                            <input id="locationAdd" type="text" placeholder="Location" name="location" required>

                            <label for="guideAdd"><b>Guide</b></label>
                            <input id="guideAdd" type="text" placeholder="Guide" name="guide" required>

                            <label for="languageAdd"><b>Language</b></label>
                            <input id="languageAdd" type="text" placeholder="Language" name="language" required>


                            <input id="eventIdAdd" type="hidden" name="eventId" value="">
                            <button type="submit" class="btn btn-success btn-sm">Add</button>
                            <button type="button" class="btn btn-danger btn-sm delete" onclick="closeForm()">
                                Cancel
                            </button>
                        </form>
                    </div>

                    <!-- The form -->
                    <div class="form-popup" id="myEditForm">
                        <form onsubmit="postData()" class="form-container">
                            <h2>Edit event</h2>

                            <label for="name"><b>Name</b></label>
                            <input id="name" type="text" placeholder="Name" name="name" required>

                            <label for="date"><b>Date</b></label>
                            <input id="date" type="datetime-local" placeholder="Date" name="date" required>

                            <label for="price"><b>Price</b></label>
                            <input id="price" step="0.5" placeholder="Price" name="price" required>

                            <label for="quantity"><b>Quantity</b></label>
                            <input id="quantity" type="number" placeholder="Quantity" name="quantity" required>

                            <label for="location"><b>Location</b></label>
                            <input id="location" type="text" placeholder="Location" name="location" required>

                            <label for="guide"><b>Guide</b></label>
                            <input id="guide" type="text" placeholder="Guide" name="guide" required>

                            <label for="language"><b>Language</b></label>
                            <input id="language" type="text" placeholder="Language" name="language" required>


                            <input id="eventId" type="hidden" name="eventId" value="">
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
                        <th>Event id</th>
                        <th>Name</th>
                        <th>Date</th>
                        <th>Price</th>
                        <th>Quantity left</th>
                        <th>Location</th>
                        <th>Guide</th>
                        <th>Language</th>
                        <th>Family price</th>
                        <th>Action</th>
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
                            <td><?php echo $row['date']; ?></td>
                            <td>€ <?php echo $row['price']; ?></td>
                            <td><?php echo $row['quantity']; ?></td>
                            <td><?php echo $row['location']; ?></td>
                            <td><?php echo $row['guide']; ?></td>
                            <td><?php echo $row['language']; ?></td>
                            <td><?php echo $row['familyPrice']; ?></td>
                            <td>
                                <form>
                                    <button type="button" name="edit_event" id="edit_event"
                                            class="btn btn-warning btn-sm edit"
                                            onclick="openEditForm(<?php echo $row["eventId"]; ?>)"> Edit
                                    </button>
                                    <button type="button" name="delete" class="btn btn-danger btn-sm delete"
                                            value="<?php echo $row['eventId']; ?>" id="delete"
                                            onclick="deleteEvent(<?php echo $row['eventId']; ?>)"> Delete
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
    function addData() {
        try{
            let url = "http://localhost/api/historycms";
            let data = {
                name: document.getElementById("nameAdd").value,
                date: document.getElementById("dateAdd").value,
                price: document.getElementById("priceAdd").value,
                quantity: document.getElementById("quantityAdd").value,
                location: document.getElementById("locationAdd").value,
                guide: document.getElementById("guideAdd").value,
                language: document.getElementById("languageAdd").value

            };

            fetch(url, {
                method: "POST",
                body: JSON.stringify(data),
                headers: {
                    "Content-Type": "application/json"
                }
            }).then(res => res.json())
                .catch(error => console.error("Error:", error))
                .then(response => console.log("Success:", response));
        }catch (e) {
            console.log(e);
        }
    }

    async function deleteEvent(id) {
        await fetch('/api/historycms?eventId=' + id, {
            method: 'DELETE',
            body: id,
        }).then(res => res.json())
            .catch(error => console.error("Error:", error))
            .then(response => console.log("Success:", response));
        document.getElementById(id).remove();
    }

    function postData() {
        let url = "http://localhost/api/historycms";
        let data = {
            name: document.getElementById("name").value,
            date: document.getElementById("date").value,
            price: document.getElementById("price").value,
            quantity: document.getElementById("quantity").value,
            location: document.getElementById("location").value,
            guide: document.getElementById("guide").value,
            language: document.getElementById("language").value,
            eventId: document.getElementById("eventId").value
        };

        fetch(url, {
            method: "PUT",
            body: JSON.stringify(data),
            headers: {
                "Content-Type": "application/json"
            }
        }).then(res => res.json())
            .catch(error => console.error("Error:", error))
            .then(response => console.log("Success:", response));
    }

    async function openEditForm(id) {
        document.getElementById("myEditForm").style.display = "block";

        let historyEvent = await getHistoryEvent(id);

        document.getElementById("name").value = historyEvent.name;
        document.getElementById("date").value = historyEvent.date;
        document.getElementById("price").value = historyEvent.price;
        document.getElementById("quantity").value = historyEvent.quantity;
        document.getElementById("location").value = historyEvent.location;
        document.getElementById("guide").value = historyEvent.guide;
        document.getElementById("language").value = historyEvent.language;
        document.getElementById("eventId").value = id;
    }

    async function getHistoryEvent(id) {
        let url = ("http://localhost/api/historycms?eventId=" + id);
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

