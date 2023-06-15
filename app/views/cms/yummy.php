<?php
include __DIR__ . '/cmsSidebar.php';

?>
<h1> Yummy restaurant management</h1>

<div class="col-sm-12 py-4">
    <span id="message"></span>
    <div class="card">
        <div class="card-header">
            <div class="row">

                <div class="col text-right">
                    <button type="button" name="add_event" id="add_event" class="btn btn-success btn-sm"
                            onclick="openForm()"> + Add Restaurant
                    </button>

                    <!-- The form -->
                    <div class="form-popup" id="myForm">
                        <form onsubmit="addData()" class="form-container">
                            <h2>Add restaurant</h2>
                            <label for=pictureAdd><b>Image</b> Files < 64mb</label>
                            <input id="pictureAdd" type="file" name="image" accept="image/*">

                            <label for="titleAdd"><b>Title</b></label>
                            <input id="titleAdd" type="text" placeholder="Title" name="title" required>

                            <label for="starsAdd"><b>Stars</b></label>
                            <input id="starsAdd" type="number" placeholder="Stars" name="stars" required>

                            <label for="priceAdd"><b>Price</b></label>
                            <input id="priceAdd" type="number" placeholder="Price" name="price" required>

                            <label for="durationAdd"><b>Duration</b></label>
                            <input id="durationAdd" type="text" placeholder=".. minutes" name="duration" required>

                            <label for="FoodAdd"><b>Type of Food</b></label>
                            <input id="FoodAdd" type="text" placeholder="Dutch, fish, ..." name="Food" required>

                            <label for="locationAdd"><b>Location</b></label>
                            <input id="locationAdd" type="text" placeholder="Location" name="location"
                                   required>

                            <input id="restaurantIdAdd" type="hidden" name="restaurantIdAdd">
                            <button type="submit" class="btn btn-success btn-sm">Add</button>
                            <button type="button" class="btn btn-danger btn-sm delete" onclick="closeForm()">
                                Cancel
                            </button>
                        </form>
                    </div>

                    <!-- The form -->
                    <div class="form-popup" id="myEditForm">
                        <form onsubmit="postData()" class="form-container">
                            <h2>Edit restaurant</h2>
                            <label for=picture><b>Image</b> Files < 64mb</label>
                            <input id="picture" type="file" name="image" accept="image/*">

                            <label for="title"><b>Title</b></label>
                            <input id="title" type="text" placeholder="Title" name="title" required>

                            <label for="stars"><b>Stars</b></label>
                            <input id="stars" type="number" placeholder="Stars" name="stars" required>

                            <label for="price"><b>Price</b></label>
                            <input id="price" type="number" placeholder="Price" name="price" required>

                            <label for="duration"><b>Duration</b></label>
                            <input id="duration" type="text" placeholder=".. minutes" name="duration" required>

                            <label for="Food"><b>Type of Food</b></label>
                            <input id="Food" type="text" placeholder="Dutch, fish, ..." name="Food" required>

                            <label for="location"><b>Location</b></label>
                            <input id="location" type="text" placeholder="Location" name="location"
                                   required>

                            <input id="restaurantId" type="hidden" name="restaurantId">
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
                <table class="table table-striped table-bordered" id="user_table">
                    <thead>
                    <tr>
                        <th>Picture</th>
                        <th scope="col">Title</th>
                        <th scope="col">Stars</th>
                        <th scope="col">Price</th>
                        <th scope="col">Duration</th>
                        <th scope="col">Type of food</th>
                        <th scope="col">Location</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php for ($i = 0; $i < count($contentRestaurants); $i++) {
                        if (isset($contentRestaurants[$i]->image))
                            $dataUri = "data:image/jpg;charset=utf;base64," . base64_encode($contentRestaurants[$i]->image);
                        ?>
                        <tr id="<?php echo $contentRestaurants[$i]->id; ?>">
                            <td width="10%"><img src="<?php echo $dataUri; ?>" alt="Image is not shown" width="80%">
                            </td>
                            <td><?= $contentRestaurants[$i]->title ?></td>
                            <td><?= $contentRestaurants[$i]->stars ?></td>
                            <td><?= $contentRestaurants[$i]->price ?></td>
                            <td><?= $contentRestaurants[$i]->duration ?></td>
                            <td><?= $contentRestaurants[$i]->typeOfFood ?></td>
                            <td><?= $contentRestaurants[$i]->location ?></td>
                            <td>
                                <form>
                                    <button type="button" name="edit_event" id="edit_event"
                                            class="btn btn-warning btn-sm edit"
                                            onclick="openEditForm(<?php echo $contentRestaurants[$i]->id; ?>)"> Edit
                                    </button>
                                    <button type="button" name="delete" class="btn btn-danger btn-sm delete"
                                            value="<?php echo $contentRestaurants[$i]->id; ?>" id="delete"
                                            onclick="deleteRestaurant(<?php echo $contentRestaurants[$i]->id; ?>)">
                                        Delete
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
        formData.append("title", document.getElementById("titleAdd").value);
        formData.append("stars", document.getElementById("starsAdd").value);
        formData.append("price", document.getElementById("priceAdd").value);
        formData.append("duration", document.getElementById("durationAdd").value);
        formData.append("typeOfFood", document.getElementById("FoodAdd").value);
        formData.append("location", document.getElementById("locationAdd").value);
        const file = document.getElementById("pictureAdd").files[0];
        formData.append("picture", file);

        const url = "http://localhost/api/yummycms";

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

    async function deleteRestaurant(id) {
        // Send a DELETE request to the server with the Restaurant ID
        await fetch('/api/yummycms?yummyId=' + id, {
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
        formData.append('id', document.getElementById("restaurantId").value);
        formData.append('stars', document.getElementById("stars").value);
        formData.append('price', document.getElementById("price").value);
        formData.append('duration', document.getElementById("duration").value);
        formData.append('typeOfFood', document.getElementById("Food").value);
        formData.append('location', document.getElementById("location").value);

        const url = "http://localhost/api/yummycms";

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

        let restaurant = await getRestaurant(id);
        console.log(restaurant);

        document.getElementById('title').value = restaurant.title;
        document.getElementById('stars').value = restaurant.stars;
        document.getElementById('price').value = restaurant.price;
        document.getElementById('duration').value = restaurant.duration;
        document.getElementById('Food').value = restaurant.typeOfFood;
        document.getElementById('location').value = restaurant.location;
        document.getElementById('restaurantId').value = id;
    }

    async function getRestaurant(id) {
        let url = ("http://localhost/api/yummycms?yummyId=" + id);
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



