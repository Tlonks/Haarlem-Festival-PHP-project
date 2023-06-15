<!DOCTYPE html>
<html id="top" lang="en">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link rel="stylesheet" href="css/Main.css" type="text/css">
<link href="/css/header.css" rel="stylesheet">
<script src="https://cdn.tiny.cloud/1/z3jn3c7rnt7c3w236hmoxjo7dsyjg5jz9y1vq2cn996q2gmf/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<?php include_once __DIR__ . "/../models/roleEnum.php"; ?>

<header>
    <style>
        #extraPages {
            background-color: black;
            width: 100%;
            height: 30px;
            color: white;
        }

        #btnCreate {
            background-color: white;
            font-size: small;
            padding: 4px;
            padding-left: 7px;
            padding-right: 7px;
        }

        .newPageLink {
            color: white;
        }
    </style>
    <?php
    require_once __DIR__ . "/../services/IntroInformationService.php";
    $IntroInformationService = new IntroInformationService();
    $info = $IntroInformationService->getAllExtraPages();
    ?>

    <div id="extraPages">

        <?php
        foreach ($info as $extraPageHeader) {
        ?> &nbsp; &nbsp; <a class="newPageLink" href="/extraPage?id=<?php echo $extraPageHeader->id ?>"><?php echo $extraPageHeader->title ?></a><?php } ?>
    </div>

    <img src="/images/Header/header2.png" alt="Image is not shown" width="100%">
    <div class="header d-flex">
        <a class="logoHaarlem" href="/"><img src="/images/Header/logo_haarlem2.png" alt="Image is not shown" width="50%"></a>
        <a class="headerItem" href="/">Home</a>
        <a class="headerItem" href="/MainYummy">Yummy</a>
        <a class="headerItem" href="/MainDance">Dance</a>
        <a class="headerItem" href="/MainTeylers">Scavengerhunt</a>
        <a class="headerItem" href="/MainJazz">Jazz</a>
        <a class="headerItem" href="/MainHistory">History</a>

        <a href="/ShoppingCart">
            <svg xmlns="http://www.w3.org/2000/svg" width="35px" fill="white" viewBox="0 0 16 16">
                <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5zM3.14 5l1.25 5h8.22l1.25-5H3.14zM5 13a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0zm9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0z" />
            </svg>
        </a>

        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;

        <div class="dropdown">
            <a href="/">
                <?php if (isset($_SESSION['userPicture'])) : ?>
                    <img src="<?php echo $_SESSION['userPicture']; ?>" alt="Image is not shown" width="35px">
                <?php else : ?>
                    <svg xmlns="http://www.w3.org/2000/svg" width="35px" fill="white" viewBox="0 0 16 16">
                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                        <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                    </svg>
                <?php endif; ?>

            </a>
            <div class="dropdown-content">

                <a href="/Profile">Profile</a>



                <?php if (isset($_SESSION['user']) && $_SESSION['Role'] == 3) : ?>
                    <a href="/cms">CMS</a>
                <?php endif; ?>
                <?php if (isset($_SESSION['user']) && $_SESSION['Role'] == 3 || isset($_SESSION['user']) && $_SESSION['Role'] == 2) : ?>
                    <a href="/QRcode">QR scanner</a>
                <?php endif; ?>

                <?php if (isset($_SESSION['user'])) : ?>
                    <a class="lastDropdown" href="/Logout">Logout</a>
                <?php else : ?>
                    <a class="lastDropdown" href="/login">Login</a>
                <?php endif; ?>
            </div>
        </div>


    </div>