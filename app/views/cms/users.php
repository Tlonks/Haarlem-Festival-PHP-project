<?php
include __DIR__ . '/cmsSidebar.php';
?>
<h1> User management</h1>

<div class="col-sm-12 py-4">
    <span id="message"></span>
    <div class="card">
        <div class="card-header">
            <div class="row">

                <div class="col text-right">
                    <button type="button" name="add_user" id="add_user" class="btn btn-success btn-sm"
                            onclick="openForm()"> + Add User
                    </button>

                    <!-- The form -->
                    <div class="form-popup" id="myForm">
                        <form onsubmit="addData()" class="form-container">
                            <h2>Add user</h2>

                            <label for="firstnameAdd"><b>First name</b></label>
                            <input id="firstnameAdd" type="text" placeholder="Firstname" name="firstname" required>

                            <label for="lastnameAdd"><b>Last name</b></label>
                            <input id="lastnameAdd" type="text" placeholder="Lastname" name="lastname" required>

                            <label for="emailAdd"><b>Email</b></label>
                            <input id="emailAdd" type="email" placeholder="example@example.com" name="email" required>

                            <label for="roleAdd"><b>Role</b></label>
                            <input id="roleAdd" type="number" placeholder="Role" name="role" required>

                            <label for="phonenumberAdd"><b>Phone number</b></label>
                            <input id="phonenumberAdd" type="number" placeholder="0646671178" name="phonenumber" required>

                            <label for="passwordAdd"><b>Password</b></label>
                            <input id="passwordAdd" type="password" placeholder="Password" name="password" required>

                            <input id="userIdAdd" type="hidden" name="userId">
                            <button type="submit" class="btn btn-success btn-sm">Add</button>
                            <button type="button" class="btn btn-danger btn-sm delete" onclick="closeForm()">
                                Cancel
                            </button>
                        </form>
                    </div>

                    <!-- The form -->
                    <div class="form-popup" id="myEditForm">
                        <form onsubmit="postData()" class="form-container">
                            <h2>Edit user</h2>

                            <label for="firstname"><b>First name</b></label>
                            <input id="firstname" type="text" placeholder="Firstname" name="firstname" required>

                            <label for="lastname"><b>Last name</b></label>
                            <input id="lastname" type="text" placeholder="Lastname" name="lastname" required>

                            <label for="email"><b>Email</b></label>
                            <input id="email" type="email" placeholder="example@example.com" name="email" required>

                            <label for="role"><b>Role</b></label>
                            <input id="role" type="number" placeholder="Role" name="role" required>

                            <label for="phonenumber"><b>Phone number</b></label>
                            <input id="phonenumber" type="number" placeholder="0646671178" name="phonenumber" required>

                            <label for="password"><b>Password</b></label>
                            <input id="password" type="password" placeholder="Password" name="password" required>

                            <input id="userId" type="hidden" name="userId">
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
                        <th scope="col">First name</th>
                        <th scope="col">Last name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Role</th>
                        <th scope="col">Phone number</th>
                        <th scope="col">Registration date</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    /** @var array $users */
                    foreach ($users as $user) {
                        ?>
                        <tr id="<?php echo $user['userId']; ?>">
                            <td> <?= $user["firstName"] ?></td>
                            <td> <?= $user["lastName"] ?></td>
                            <td> <?= $user["email"] ?></td>
                            <td> <?php if ($user['role'] == 1) {
                                    echo "Employee";
                                } else if ($user['role'] == 2) {
                                    echo "User";
                                } else if ($user['role'] == 3) {
                                    echo "Administrator";
                                } else {
                                    echo "guest";
                                } ?>
                            </td>
                            <td> <?= $user["phoneNumber"] ?> </td>
                            <td> <?= $user["registrationDate"] ?> </td>
                            <td>
                                <form>
                                    <button type="button" name="edit_user" id="<?php echo $user['userId']; ?>"
                                            class="btn btn-warning btn-sm edit"
                                            onclick="openEditForm(<?php echo $user["userId"]; ?>)"> Edit
                                    </button>
                                    <button type="button" name="delete" class="btn btn-danger btn-sm delete"
                                            value="<?php echo $user['userId']; ?>" id="delete <?php echo $user['userId']; ?>"
                                            onclick="deleteUser(<?php echo $user['userId']; ?>)"> Delete
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
        try {
            let url = "http://localhost/api/usercms";
            let data = {
                firstName: document.getElementById("firstnameAdd").value,
                lastName: document.getElementById("lastnameAdd").value,
                email: document.getElementById("emailAdd").value,
                role: document.getElementById("roleAdd").value,
                phoneNumber: document.getElementById("phonenumberAdd").value,
                password: document.getElementById("passwordAdd").value,
                registrationDate: Date.now(),
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

            return false;
        } catch (e) {
            console.log(e);
        }
    }

    function deleteUser(id) {
        // Send a DELETE request to the server with the User ID
        fetch("/api/usercms?userId=" + id, {
            method: "DELETE"
        })
            .then(response => response.json())
            .then(data => {
                if (data.message === "Success") {
                    // If the server returns a success message, update the table
                    document.getElementById(id).remove();
                } else {
                    // If the server returns an error, display it
                    console.log(data.message);
                }
            });
    }

    function postData() {
        let url = "http://localhost/api/usercms";
        let data = {
            firstName: document.getElementById("firstname").value,
            lastName: document.getElementById("lastname").value,
            email: document.getElementById("email").value,
            role: document.getElementById("role").value,
            phoneNumber: document.getElementById("phonenumber").value,
            password: document.getElementById("password").value,
            userId: document.getElementById("userId").value,
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

        let user = await getUserById(id);

        document.getElementById("firstname").value = user.firstName;
        document.getElementById("lastname").value = user.lastName;
        document.getElementById("email").value = user.email;
        document.getElementById("role").value = user.role;
        document.getElementById("phonenumber").value = user.phoneNumber;
        document.getElementById("userId").value = id;

    }

    async function getUserById(id) {
        let url = ("http://localhost/api/usercms?userId=" + id);
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

