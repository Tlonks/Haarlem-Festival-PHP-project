<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Password reset</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" rel="stylesheet">
    <link href="../css/loginStylesheet.css" rel="stylesheet">


</head>

<body>

    <div class="row">
        <div class="col">
            <div id="cardLogin" class="card col-md-6 mx-auto">

                <div class="card-body">
                    <form action="/PasswordReset/resetPassword" method="post">

                        <h1 id="loginText">Enter a new password</h1>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">New password</label>
                            <input type="password" name="password" class="form-control" id="exampleInputEmail1">

                        </div>

                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Confirm password</label>
                            <input type="password" name="passwordRepeat" class="form-control" id="exampleInputEmail1">

                        </div>

                        <button id="loginButton" type="submit" name="resetPassword" class="btn">Reset</button>

                        <label class="form-label">
                            <?php if(!empty($error)){echo $error;}; ?>
                        </label>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>

</body>

</html>