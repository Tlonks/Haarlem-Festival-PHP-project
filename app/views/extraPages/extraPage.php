<?php
include_once __DIR__ . "/../header.php";
?>
<title><?php echo $extraPage[0]->title; ?></title>
<p class="title"><?php echo $extraPage[0]->title; ?></p>

<?php
    include __DIR__ . '/../BackArrow.php';
    ?>

<div class="container">

    <?php echo $extraPage[0]->htmlData; ?>

</div>
