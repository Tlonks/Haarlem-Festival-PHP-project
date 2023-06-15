<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require_once __DIR__ . '/../vendor/autoload.php';

class MailService
{
    public function mailPDF($qrCodeArray, $email, $name, $order, $orderItems, $phoneNumber, $address, $postalCode, $birthdate, $city, $country)
    {
        $pdf = new CreatePdfService;
        $pdfInvoice = $pdf->createPDFInvoice($name, $order[0], $orderItems, $phoneNumber, $address, $postalCode, $city, $country, false);
        $pdfTickets = $pdf->createPDFTickets($qrCodeArray, $order, $orderItems);
        // Create a new PHPMailer object
        $mail = new PHPMailer;

        $mail->SMTPDebug = SMTP::DEBUG_SERVER; //Enable verbose debug output
        $mail->SMTPDebug = 0;
        $mail->isSMTP(); //Send using SMTP
        $mail->Host = 'smtp.gmail.com'; //Set the SMTP server to send through
        $mail->SMTPAuth = true; //Enable SMTP authentication
        $mail->Username = 'thefestivalhaarlem@gmail.com'; //SMTP username
        $mail->Password = 'wonbwnfnxgnhpcdf'; //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //Enable implicit TLS encryption
        $mail->Port = 465; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('thefestivalhaarlem@gmail.com', 'The Festival');
        $mail->addAddress($email, $name); //Add a recipient

        //Content
        $mail->isHTML(true); //Set email format to HTML
        $mail->Subject = 'Tickets The Festival';

        $mail->Body = "<h1>The Festival</h1><br> <h1>Order information</h1> <br> <h3>order: " . $order[0]['id'] . "<br>" . "Order date: " . date("Y-m-d") . "<br>" . "</h3> <br> <h2>Personal information</h2> <br>" . "Fullname: " . $name . "<br>" . "Birthdate: " . $birthdate . "<br>" . "Email: " . $email . "<br>" . "Phonenumber: " . $phoneNumber . "<br>" . "Address: " . $address . "<br>" . "Postal code:" . $postalCode . "<br>" . "city: " . $city . "<br>" . "Country: " . $country . "<br> <h2>Order items</h2> <br>";

        for ($i = 0; $i < count($orderItems); $i++) {
            $mail->Body .= "Event: " . $orderItems[$i]['name'] . "<br>" . "Date: " . $orderItems[$i]['date'] . "<br>" . "Category: " . $orderItems[$i]['category'] . "<br>" . "Price: " . $orderItems[$i]['price'] . "<br>" . "Amount: " . $orderItems[$i]['quantityOrder'] . "<br><br>";
        }
        $mail->Body .= "Total price: " . $order[0]['totalPrice'] . "<br>" . "Total added VAT: " . $order[0]['addedVAT'] . "<br><br>";
        $mail->Body .= "You can find your tickets in the attachment.<br>";
        $mail->Body .= "Thank you for your order!<br><br>";
        $mail->AddStringAttachment($pdfTickets, 'Tickets.pdf', 'base64', 'application/pdf');
        $mail->AddStringAttachment($pdfInvoice, 'Invoice.pdf', 'base64', 'application/pdf');



        $mail->send();
    }
    //Mail sturen met wachtwoord reset code
    //https://github.com/PHPMailer/PHPMailer
    //Code is van hierboven genoemde bron
    public function sendMail($email, $code)
    {
        $mail = new PHPMailer(true);


        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER; //Enable verbose debug output
            $mail->SMTPDebug = 0;
            $mail->isSMTP(); //Send using SMTP
            $mail->Host = 'smtp.gmail.com'; //Set the SMTP server to send through
            $mail->SMTPAuth = true; //Enable SMTP authentication
            $mail->Username = 'thefestivalhaarlem@gmail.com'; //SMTP username
            $mail->Password = 'wonbwnfnxgnhpcdf'; //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //Enable implicit TLS encryption
            $mail->Port = 465; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('thefestivalhaarlem@gmail.com', 'The Festival');
            $mail->addAddress($email, 'User'); //Add a recipient


            //Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz'); //Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg'); //Optional name

            //Content
            $mail->isHTML(true); //Set email format to HTML
            $mail->Subject = 'Password reset';
            $mail->Body = "Your reset code: " . $code;


            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    public function sendConfirmation($email, $message)
    {
        $mail = new PHPMailer(true);


        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER; //Enable verbose debug output
            $mail->SMTPDebug = 0;
            $mail->isSMTP(); //Send using SMTP
            $mail->Host = 'smtp.gmail.com'; //Set the SMTP server to send through
            $mail->SMTPAuth = true; //Enable SMTP authentication
            $mail->Username = 'thefestivalhaarlem@gmail.com'; //SMTP username
            $mail->Password = 'wonbwnfnxgnhpcdf'; //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //Enable implicit TLS encryption
            $mail->Port = 465; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('thefestivalhaarlem@gmail.com', 'The Festival');
            $mail->addAddress($email, 'User'); //Add a recipient


            //Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz'); //Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg'); //Optional name

            //Content
            $mail->isHTML(true); //Set email format to HTML
            $mail->Subject = 'Account information changed';
            $mail->Body = $message;


            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    public function sendTestMail($email, $qrCodeArray, $orderItems)
    {
        $mail = new PHPMailer(true);


        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER; //Enable verbose debug output
            $mail->SMTPDebug = 0;
            $mail->isSMTP(); //Send using SMTP
            $mail->Host = 'smtp.gmail.com'; //Set the SMTP server to send through
            $mail->SMTPAuth = true; //Enable SMTP authentication
            $mail->Username = 'thefestivalhaarlem@gmail.com'; //SMTP username
            $mail->Password = 'wonbwnfnxgnhpcdf'; //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //Enable implicit TLS encryption
            $mail->Port = 465; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('thefestivalhaarlem@gmail.com', 'The Festival');
            $mail->addAddress($email, 'User'); //Add a recipient


            //Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz'); //Add attachments


            //Content
            $mail->isHTML(true); //Set email format to HTML
            $mail->Subject = 'test';
            $mail->Body = "Test codes: ";
            for ($i = 0; $i < count($qrCodeArray); $i++) {
                for ($j = 0; $j < count($qrCodeArray[$orderItems[$i]['0']]['value']); $j++) {
                    //echo $qrCodeArray[$orderItems[$i]['0']]['value'][$j]['value'];
                    $imgdata = base64_encode($qrCodeArray[$orderItems[$i]['0']]['value'][$j]['value']);
                    $final = base64_decode($imgdata);
                }
            }




            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
