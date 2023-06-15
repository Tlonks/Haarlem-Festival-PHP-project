<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>The Lost Calculator</title>
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
            <div id="ch1-active-Right">1</div>
            <div id="ch2-active-Right">2</div>

        </div>

        <h2 id="firstChallenge">
            Challenge 2: The Lost Calculator
        </h2>

        <div id="correctText">
            <p id="textR">
                Correct!<br>
                Clue: Teylers best friend was called huygens, search his painting in the next room.
            </p>

        </div>

        <div id="explanation">
            <p id="explText">
                Explanation:<br>
                When using maths there is an fixed order deciding when to multiply, divide, add or subtract. We call it
                order of operations. By using this you will always get the same answer.
            </p>

        </div>

        <h3 id="codeText">
            Get the code from Prof. Digit
        </h3>

        <h3 id="factsTitle">
            Math facts
        </h3>

        <h3 id="codeEnterText">
            Enter the code:
        </h3>

        <form action="/SecondChallenge/secondRight" method="post">

            <div id="inputDiv">
                <input type="text" name="code" class="form-control" id="codeInput">
            </div>

            <div id="buttonDiv">
                <button type="submit" name="codeEnterButton" class="btn" id="codeSubmitButton">Submit</button>
            </div>

        </form>

        <div id="picture2">
            <img id="upArrow4" src="/images/Teylers/upArrow.png" alt="Image is not shown">
        </div>
        <hr id="line">



    </main>






    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>




</body>

</html>