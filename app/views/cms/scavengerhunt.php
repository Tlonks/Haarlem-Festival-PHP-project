<?php
include __DIR__ . '/cmsSidebar.php';
?>
<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Scavenger hunt management</title>
    <link href="../css/cmsTylers.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <h1 class="title">
        Manage scavenger hunt
    </h1>

    <section id="pictureField">
        <img id="headerPicture" src="<?php echo $headerPicture ?>" alt="header picture">

        <div class="col-md-6">
            <div class="h-200 p-5 bg-light border rounded-3">
                <h2>Change header picture</h2>


                <form lang="en" action="/cms/changeTeylerPage" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label id=imageLabel>Select Image File:</label>
                        <input type="file" name="image">
                        <p><small>Picture < 64mb</small>
                        </p>
                    </div>

                    <button id="submitButton" type="submit" name="submit" value="upload"
                        class="btn btn-success">Edit</button>
                </form>

            </div>
        </div>
    </section>

    <section id="editFields">
        <div class="card">
            <form id="form" action="/cms/changeTeylerPage" method="post">
                <h5><label for="headerPicture">Header</label></h5><br>
                <textarea name="header" id="header" cols="30" rows="6"><?php echo $header ?></textarea><br>

                <button class="btn btn-success" type="submit" name="editHeaderButton">
                    Edit
                </button>
            </form>
        </div>

        <div class="card">
            <form id="form" action="/cms/changeTeylerPage" method="post">
                <h5><label for="headerText">Sub header text</label></h5><br>
                <textarea name="headerText" id="headerText" cols="30" rows="6"><?php echo $headerText ?></textarea><br>
                <button class="btn btn-success" type="submit" name="editSubButton">
                    Edit
                </button>
            </form>
        </div>

        <div class="card">
            <form id="form" action="/cms/changeTeylerPage" method="post">
                <h5><label for="mainText">Main text</label></h5><br>
                <textarea name="mainText" id="mainText" cols="30" rows="6"><?php echo $mainText ?></textarea><br>
                <button class="btn btn-success" type="submit" name="editMainButton">
                    Edit
                </button>
            </form>
        </div>
        
    </section>

</body>


<script>

</script>