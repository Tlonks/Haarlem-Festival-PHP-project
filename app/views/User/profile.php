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
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>The secret of Tyler</title>
    <link href="../css/Profile.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <?php
  include __DIR__ . '/../BackArrow.php';
  ?>
    <div class="container py-4">
        

        <div  class="p-5 mb-4 bg-light rounded-1">
            <div  class="container-fluid py-5">
                <h1 class="display-5 fw-bold">
                    <?php echo "Welcome ", $_SESSION["user"]["firstName"], " ", $_SESSION["user"]["lastName"]; ?>
                </h1>
                <p class="col-md-8 fs-4">On this page you can see your own information or maybe fancy a new profile
                    picture?
                </p>

            </div>
        </div>

        <div class="row align-items-md-stretch">

            <div class="col-md-6">
                <div class="h-100 p-5 bg-light border rounded-3">
                    <h2>Your information</h2>
                    <img id="img" class="card-img-top" src="<?php echo $_SESSION['userPicture']; ?>" alt="Card image cap">
                    <div id=userCardBody class="card-body">

                        <h5 class="card-title">
                            <?php echo $_SESSION["user"]["firstName"], " ", $_SESSION["user"]["lastName"]; ?>
                        </h5>
                        <label class="display-7 fw-bold">Username:</label><br>
                        
                        <h7 class="card-title">
                            <? echo $_SESSION["user"]["email"]; ?>
                        </h7><br>
                        
                        <label class="display-7 fw-bold">Phonenumber:</label><br>
                        <h7 class="card-title">
                            <? echo $_SESSION["user"]["phoneNumber"]; ?>
                        </h7><br>

                        <label class="display-7 fw-bold">Registration date:</label><br>
                        <h7 class="card-title">
                            <? echo $_SESSION["user"]["registrationDate"]; ?>
                        </h7><br>
                        
                        
                        <button id="editButton" class="btn"><a href="/Profile/editProfile">Edit</a></button>
                        

                        
                    

                    </div>

                </div>
            </div>

            <div class="col-md-6">
                <div class="h-100 p-5 bg-light border rounded-3">
                    <h2>Change profile picture</h2>


                    <form lang="en" action="/Profile" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label id=imageLabel>Select Image File:</label>
                            <input type="file" name="image">
                            <p><small>Picture < 64mb</small>
                            </p>
                        </div>

                        <button id="submitButton" type="submit" name="submit" value="upload"
                            class="btn">Change</button>
                    </form>

                </div>
            </div>
        </div>

    </div>
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