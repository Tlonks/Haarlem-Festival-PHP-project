<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>The secret of Tyler</title>
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

        <h2 id="code">
            Enter the code
        </h2>

        <form action="/MainScavengerhunt" method="post">

            <div id="inputDiv">
                <input type="text" name="code" class="form-control" id="codeInput" readonly>
            </div>

            <div id="buttonDiv">
                <button type="submit" name="codeEnterButton" id="enterButton" class="btn">Enter</button>
            </div>

        </form>

        <container id="keypad">

            <button onclick="add('1')" id="inputButton">1</button>
            <button onclick="add('2')" id="inputButton">2</button>
            <button onclick="add('3')" id="inputButton">3</button>
            <button onclick="add('4')" id="inputButton">4</button>
            <button onclick="add('5')" id="inputButton">5</button>
            <button onclick="add('6')" id="inputButton">6</button>
            <button onclick="add('7')" id="inputButton">7</button>
            <button onclick="add('8')" id="inputButton">8</button>
            <button onclick="add('9')" id="inputButton">9</button>
            <button onclick="add('-')" id="inputButton">-</button>
            <button onclick="add('0')" id="inputButton">0</button>





        </container>







    </main>


    <footer>
        <h2 id="footerText">
            The code is available at the entrance
        </h2>
    </footer>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>



    <script>
        function add(Value) {

            if (Value === '-') {
                var string = document.getElementById("codeInput").value;
                document.getElementById("codeInput").value = "";
                string = string.slice(0, -1);
                document.getElementById("codeInput").value = string;
            }
            else if (Value === 'Y') {

            }
            else {
                document.getElementById("codeInput").value += Value;
            }

        }
    </script>



</body>

</html>