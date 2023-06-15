<?php
require_once __DIR__ . '/../vendor/tecnickcom/tcpdf/tcpdf.php';

class CreatePdfService
{

    // heel gestruggled met font werkend te kijken maar was niet gelukt
    public function createPDFTickets($qrCodeArray, $order, $orderItems)
    {
        try {
            // Create a new TCPDF object
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

            // hij haalt alle orderitems op en dan ckeckt die ook de quantity 
            // zodat je van ieder ticket een pdf met qr code krijgt
            for ($i = 0; $i < count($orderItems); $i++) {
                for ($j = 0; $j < $orderItems[$i]['quantityOrder']; $j++) {

                    $pdf->AddPage();
                    $pdf->SetFont('times', 'B', 25);
                    $pdf->Write(0, 'The Festival', '', 0, 'L', true, 0, false, false, 0);
                    $pdf->SetFont('times', '', 18);
                    $pdf->Write(10, 'Your order', '', 0, 'L', true, 0, false, false, 0);
                    $pdf->Write(10, '#' . $order[0]['id'], '', 0, 'L', true, 0, false, false, 0);

                    $pdf->Write(7, '  ', '', 0, 'L', true, 0, false, false, 0);
                    $pdf->SetFont('times', 'B', 15);
                    $pdf->Write(10, '-  ' . $orderItems[$i]['name'], '', 0, 'L', true, 0, false, false, 0);

                    $pdf->SetFont('times', '', 15);
                    if ($orderItems[$i]['type'] == 'Solo') {
                        $pdf->Write(2, '       1x ' .  $orderItems[$i]['type'] . ' ticket       €' . sprintf("%0.2f", $orderItems[$i]['price']) . '    -    ' . date("H:i   d M Y", strtotime($orderItems[$i]['date'])), '', 0, 'L', true, 0, false, false, 0);
                    } else if ($orderItems[$i]['type'] == 'Family') {
                        $pdf->Write(2, '       1x ' .  $orderItems[$i]['type'] . ' ticket   €' . sprintf("%0.2f", 60) . '    -    ' . date("H:i   d M Y", strtotime($orderItems[$i]['date'])), '', 0, 'L', true, 0, false, false, 0);
                    }

                    $imgdata = base64_encode($qrCodeArray[$orderItems[$i]['0']]['value'][$j]['value']);
                    $final = base64_decode($imgdata);
                    $pdf->Image('@' . $final, 80, 210, 50);
                }
            }

            // Output the PDF as a string
            return $pdf->Output('Tickets.pdf', 'S');
        } catch (Exception $e) {
            echo $e;
        }
    }

    public function createPDFInvoice($name, $order, $orderItems, $phoneNumber, $address, $postalCode, $city, $country, $download)
    {
        try {
            // Create a new TCPDF object
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

            $pdf->AddPage();

            $pdf->SetFont('times', 'B', 25);
            $pdf->Write(0, 'The Festival', '', 0, 'L', true, 0, false, false, 0);
            $pdf->SetFont('times', '', 18);
            $pdf->Write(10, 'Your order', '', 0, 'L', true, 0, false, false, 0);
            $pdf->Write(10, '#' . $order['id'], '', 0, 'L', true, 0, false, false, 0);

            $this->checkdownloadedInvoice($download, $pdf, $name, $postalCode, $city, $country, $phoneNumber, $address);

            $width_cell = $this->createTableInvoice($pdf, $orderItems);

            $this->showPriceInvoice($pdf, $width_cell, $order);

            // Output the PDF as a string
            return $pdf->Output('Invoice.pdf', 'S');
        } catch (Exception $e) {
            echo $e;
        }
    }

    public function showPriceInvoice($pdf, $width_cell, $order){
        $pdf->Cell(200, 10, '', 0, 1, false);
        $pdf->Cell(125, 10, '', 0, 0, false);
        $pdf->Cell(30, 10, 'Subtotal', 1, 0, false);
        $pdf->Cell($width_cell[4], 10, '€' . sprintf("%0.2f", $order['totalPrice']) - $order['addedVAT'], 1, 1, false);
        $pdf->Cell(125, 10, '', 0, 0, false);
        $pdf->Cell(30, 10, 'VAT', 1, 0, false);
        $pdf->Cell($width_cell[4], 10, '€' . $order['addedVAT'], 1, 1, false);
        $pdf->Cell(125, 10, '', 0, 0, false);
        $pdf->Cell(30, 10, 'Total', 1, 0, false);
        $pdf->Cell($width_cell[4], 10, '€' . sprintf("%0.2f", $order['totalPrice']), 1, 1, false);
    }

    public function createTableInvoice($pdf, $orderItems)
    {
        $width_cell = array(30, 65, 30, 30, 35);

        $pdf->SetFont('times', 'B', 18);
        $pdf->Cell($width_cell[0], 10, 'Event id', 1, 0, false);
        $pdf->Cell($width_cell[1], 10, 'Event', 1, 0, false);
        $pdf->Cell($width_cell[2], 10, 'Price', 1, 0, false);
        $pdf->Cell($width_cell[3], 10, 'Amount', 1, 0, false);
        $pdf->Cell($width_cell[4], 10, 'Total', 1, 1, false);

        $pdf->SetFont('times', '', 15);
        $orderCount = 0;

        foreach ($orderItems as $items) {
            $pdf->Cell($width_cell[0], 10, $items['eventId'], 1, 0, false);
            $pdf->Cell($width_cell[1], 10, $items['name'], 1, 0, false);
            $pdf->Cell($width_cell[2], 10, '€' . $items['price'], 1, 0, false);
            $pdf->Cell($width_cell[3], 10, $items['quantityOrder'], 1, 0, false);
            $pdf->Cell($width_cell[4], 10, '€' . $items['price'] * $items['quantityOrder'], 1, 1, false);
            $orderCount += $items['quantityOrder'];
        }

        return $width_cell;
    }

    public function checkdownloadedInvoice($download, $pdf, $name, $postalCode, $city, $country, $phoneNumber, $address)
    {
        if (!$download) {
            $pdf->Cell(10, 10, '', 0, 1);

            $pdf->SetFont('times', 'B', 18);
            $pdf->Write(10, 'Billed To', '', 0, 'L', true, 0, false, false, 0);
            $pdf->SetFont('times', '', 15);
            $pdf->Write(10, $name, '', 0, 'L', true, 0, false, false, 0);
            $pdf->Write(10, $postalCode . ', ' . $address, '', 0, 'L', true, 0, false, false, 0);
            $pdf->Write(10, $city, '', 0, 'L', true, 0, false, false, 0);
            $pdf->Write(10, $country, '', 0, 'L', true, 0, false, false, 0);
            $pdf->Write(10, $phoneNumber, '', 0, 'L', true, 0, false, false, 0);
        }

        $pdf->Cell(10, 10, '', 0, 1);
    }
}
