<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>The egg problem</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" rel="stylesheet">
    <link href="../css/teylers.css" rel="stylesheet">
</head>

<body>

    <header>
        <h1 id="title">
            The Secret of Professor Teyler
        </h1>

    </header>

    <main>

        <h2 id="challenges">
            Challenges
        </h2>

        <div class="flex">
            <div id="ch1-active">1</div>
            <div id="ch2">2</div>

        </div>

        <h2 id="firstChallenge">
            Challenge 1: The egg problem
        </h2>

        <h2 id="challengeInfo">
            Find the 2 fresh eggs out of the 6
        </h2>

        <h3 id="answerLabel">
            Wright down your answer on how to find the 2 fresh eggs:
        </h3>

        <form action="/FirstChallenge/firstAnswer" method="post">

            <div id="text">
                <input type="textarea" name="answer" class="form-control" id="answer">
            </div>

            <div id="buttonSubmit">
                <button class="btn" type="submit" name="answerSubmitButton" id="submitButton">Submit</button>
            </div>

        </form>

        <button id="1">
            <div id="hint1">Hint 1</div>
        </button>

        <button id="2">
            <div id="hint2">Hint 2</div>
        </button>

        <div id="hide">Hint: a glass of water?</div>
        <div id="hide2">Hint: Float or sink?</div>


        <div id="picture2">
            <img id="upArrow3" src="/images/Teylers/upArrow.png" alt="Image is not shown">
        </div>
        <hr id="line">



    </main>






    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
    <script type="text/javascript" src="js/keyboard.js"></script>

    <script>
        const targetDiv = document.getElementById("hide")
        const btn = document.getElementById("1");
        btn.onclick = function () {
            if (targetDiv.style.display !== "none") {
                targetDiv.style.display = "none";
            } else {
                targetDiv.style.display = "block";
            }
        };

        const targetDiv2 = document.getElementById("hide2")
        const btn2 = document.getElementById("2");
        btn2.onclick = function () {
            if (targetDiv2.style.display !== "none") {
                targetDiv2.style.display = "none";
            } else {
                targetDiv2.style.display = "block";
            }
        };
    </script>
</body>

</html>