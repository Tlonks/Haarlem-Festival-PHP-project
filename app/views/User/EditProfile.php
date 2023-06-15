<?php
include __DIR__ . '/../header.php';
?>
<html>

</html>
<p class="title">
    Profile
</p>
<?php

?>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Edit profile</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" rel="stylesheet">
    <link href="../css/Profile.css" rel="stylesheet">

</head>

<body>

    <?php
    include __DIR__ . '/../BackArrow.php';
    ?>
    <form action="/Profile/editProfile" method="post" enctype="multipart/form-data">

        <div id="registerBackground" class="card col-md-6 mx-auto" style="border-radius: 25px;">


            <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Edit Profile</p>

            

            <form class="mx-1 mx-md-4">

                <div id="items" class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                        <input type="text" value="<?php echo $_SESSION["user"]["firstName"]; ?>" id="form3Example1c"
                            name="firstname" class="form-control" />
                        <label class="form-label" for="form3Example1c">Firstname</label>
                    </div>
                </div>

                <div id="items" class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                        <input type="text" value="<?php echo $_SESSION["user"]["lastName"]; ?>" id="form3Example1c"
                            name="lastname" class="form-control" />
                        <label class="form-label" for="form3Example1c">Lastname</label>
                    </div>
                </div>

                <div id="items" class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                        <input type="email" name="email" value="<?php echo $_SESSION["user"]["email"]; ?>"
                            id="form3Example1c" class="form-control" />
                        <label class="form-label" for="form3Example3c">Email</label>
                    </div>
                </div>

                <div id="items" class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                        <input type="password" name="password" id="form3Example1c" class="form-control" />
                        <label class="form-label" for="form3Example4c">Password</label>
                    </div>
                </div>

                <div id="items" class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                        <input type="password" name="passwordConfirm" id="form3Example1c" class="form-control" />
                        <label class="form-label" for="form3Example4c">Password confirmation</label>
                    </div>
                </div>

                <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                    <button type="submit" name="changeButton" id="changeButton" class="btn btn-lg">Change</button>
                </div>
        </div>
    </form>
</body>

</html>

<?php

include __DIR__ . '/../footer.php';
?>
<html>

<style>
    body {
        background-color: #EDE6E6;
    }
</style>

</html>