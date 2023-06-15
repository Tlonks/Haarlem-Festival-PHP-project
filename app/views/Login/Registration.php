<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>New user</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" rel="stylesheet">
    <link href="../css/loginStylesheet.css" rel="stylesheet">

</head>

<body>


    <form action="/registration" method="post" enctype="multipart/form-data">

        <div id="registerBackground" class="card col-md-6 mx-auto" style="border-radius: 25px;">


            <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Sign up</p>

            <p id="backButton">
                <a href="/Login" id="loginButton" class="btn my-2">Back to login</a>
            </p>

            <form class="mx-1 mx-md-4">

                <h3>
                    <?php if(!empty($error)){echo $error;}; ?>
                </h3>

                <div id="items" class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                        <input type="text" id="form3Example1c" name="firstname" class="form-control" />
                        <label class="form-label" for="form3Example1c">Firstname</label>
                    </div>
                </div>

                <div  id="items" class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                        <input type="text" id="form3Example1c" name="lastname" class="form-control" />
                        <label class="form-label" for="form3Example1c">Lastname</label>
                    </div>
                </div>

                <div  id="items" class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                        <input type="email" name="email" id="form3Example3c" class="form-control" />
                        <label class="form-label" for="form3Example3c">Email</label>
                    </div>
                </div>

                <div  id="items" class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                        <input type="password" name="password" id="form3Example4c" class="form-control" />
                        <label class="form-label" for="form3Example4c">Password</label>
                    </div>
                </div>

                <div  id="items" class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                        <input type="number" name="number" id="form3Example4c" class="form-control" />
                        <label class="form-label" for="form3Example4c">Phone number</label>
                    </div>
                </div>

                <div  id="items" class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-photo-video fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                        <label id=imageLabel>Select profile picture:</label>
                        <input type="file" name="image">
                        <label>Files < 64mb</label>
                    </div>
                </div>

                <div   class="form-check d-flex justify-content-center mb-5">
                    <input class="form-check-input me-2" type="checkbox" value="" id="form2Example3c" />
                    <label class="form-check-label" for="form2Example3">
                        I agree all statements in <a href="#!">Terms of service</a>
                    </label>
                </div>

                <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                    <button type="submit" name="registerButton" id="loginButton" class="btn btn-lg">Register</button>
                </div>

            </form>



        </div>




        </div>


    </form>
    </div>
    </section>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>

</body>

</html>