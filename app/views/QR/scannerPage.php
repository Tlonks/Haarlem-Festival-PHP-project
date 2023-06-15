<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/QR.css">
</head>

<body>

    <!DOCTYPE html>
    <html>

    <head>
        <title>QR Scanner</title>
        <script type="text/javascript"
            src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    </head>

    <body>
        <div id="title">
            <h1>The Festival</h1>

        </div>
        <div id="sub">
            <p id="scan">Scan a QR code</p>
        </div>
        <?php
        include __DIR__ . '/../BackArrow.php';
        ?>
        <div id="vid">
            <video id="preview"></video>
        </div>

        <div id="feedback">
            <p id="feedbackText"> </p>
        </div>

        <script type="text/javascript">
            //https://github.com/schmich/instascan
            //Code is gebaseerd op hierboven staande bron
            //Qr code scanner met behulp van de instascan library
            let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
            scanner.addListener('scan', function (content) {
                
                scan(content);
            });
            Instascan.Camera.getCameras().then(function (cameras) {
                if (cameras.length > 0) {
                    scanner.start(cameras[0]);

                } else {
                    console.error('No cameras found.');
                }
            }).catch(function (error) {
                console.error(error);
            });
            //Verstuurd de data naar de server en krijgt reactie terug
            function scan(result) {

                

                try {
                    let url = "http://localhost/QRcode/scan";
                    let data = {
                        key: result

                    };
                    

                    fetch(url, {
                        method: "POST",
                        body: JSON.stringify(data),
                        headers: {
                            "Content-Type": "application/json"
                        }
                    }).then(res => res.json())
                        .catch(error => console.error("Error:", error))
                        .then(response => document.getElementById("feedbackText").innerHTML = response.message),document.getElementById("feedbackText").style.fontSize = "30px";
                        
                        
                        
                        setTimeout(function emptyString(){
                            document.getElementById("feedbackText").innerHTML = "";
                        },3000);

                } catch (error) {
                    console.log(error);
                }

            };

            

            


        </script>
    </body>

    </html>



</body>

</html>