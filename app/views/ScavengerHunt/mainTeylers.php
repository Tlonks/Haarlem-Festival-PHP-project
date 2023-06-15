<?php
include __DIR__ . '/../header.php';
?>

<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>The secret of Tyler</title>
    <link href="../css/DesktopTeylers.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
<p class="title">
    The secret of Tyler
</p>
<?php
include __DIR__ . '/../BackArrow.php';
?>
<div class="teylersStructure">
    <?php echo $teylersPage[0]->htmlData; ?>

</body>

<style>
    body {
        background-color: #EDE6E6;
    }
</style>


<?php
include __DIR__ . '/../footer.php';
?>

</html>