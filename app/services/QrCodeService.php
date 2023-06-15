<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../repositories/TicketRepository.php';

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\ValidationException;



class QrCodeService
{
    //Qr code genereren
    //https://packagist.org/packages/endroid/qr-code
    //Code is van de bovenstaande link
    public function generateQR($key)
    {

        $writer = new PngWriter();

        // Create QR code
        $qrCode = QrCode::create($key)
            ->setEncoding(new Encoding('UTF-8'))
            ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
            ->setSize(300)
            ->setMargin(10)
            ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
            ->setForegroundColor(new Color(0, 0, 0))
            ->setBackgroundColor(new Color(255, 255, 255));

        // Create generic logo
        $logo = Logo::create(__DIR__ . '/images/Header/logo_haarlem2.png')
            ->setResizeToWidth(50);

        // Create generic label
        $label = Label::create('Haarlem Festival ticket')
            ->setTextColor(new Color(255, 0, 0));

        $result = $writer->write($qrCode, $logo = null, $label);
        $data = $result->getString();
       
        return $data;

    }

}