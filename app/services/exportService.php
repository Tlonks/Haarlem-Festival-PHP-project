<?php

class ExportService
{
    //Controleert welk type bestand er geexporteerd moet worden
    public function export($orders, $fileType, $columns)
    {
        if ($fileType == 'csv') {
            $this->exportCSV($orders, $columns);
        } else if ($fileType == 'excel') {
            $this->exportExcel($orders, $columns);
        }
    }
    //Exporteert de data naar een csv bestand
    //https://www.codexworld.com/export-data-to-csv-file-using-php-mysql/
    //Code is gebaseerd op hierboven staande bron
    private function exportCSV($orders, $columns)
    {
        $header_args = $columns;
        $delimiter = ";";
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=orderInformation.csv');

        $output = fopen('php://output', 'w');

        fputcsv($output, $header_args, $delimiter);

        foreach ($orders as $order) {
            $row = array();
            for ($i = 0; $i < count($columns); $i++) {
                if ($columns[$i] == 'total') {
                    $total = $order->totalPrice;
                    if ($total != 0) {
                        $row[] = $total;
                    }
                } else if ($columns[$i] == 'VAT') {
                    $VAT = $order->addedVAT;
                    if ($VAT != 0) {
                        $row[] = $VAT;
                    }
                } else if ($columns[$i] == 'isPaid') {
                    $status = $order->isPaid;
                    if ($status != 0) {
                        $row[] = $status;
                    }
                } else if ($columns[$i] == 'order id') {
                    $id = $order->id;
                    if ($id != 0) {
                        $row[] = $id;
                    }
                }
            }
            fputcsv($output, $row, $delimiter);
        }

        exit;
    }
    //Exporteert de data naar een excel bestand
    //https://www.codexworld.com/export-data-to-excel-csv-format-using-php-mysql/
    //Code is gebaseerd op hierboven staande bron
    private function exportExcel($orders, $columns)
    {
        // Filter the excel data 
        function filterData(&$str)
        {
            $str = preg_replace("/\t/", "\\t", $str);
            $str = preg_replace("/\r?\n/", "\\n", $str);
            if (strstr($str, '"'))
                $str = '"' . str_replace('"', '""', $str) . '"';
        }

        // Excel file name for download 
        $fileName = "orderData" . date('Y-m-d') . ".xls";

        // Column names 
        $fields = $columns;

        // Display column names as first row 
        $excelData = implode("\t", array_values($fields)) . "\n";

        // Fetch records from database 
        foreach($orders as $order){
            $row = array();
            for ($i = 0; $i < count($columns); $i++) {
                if ($columns[$i] == 'total') {
                    $total = $order->totalPrice;
                    if ($total != 0) {
                        $row[] = $total;
                    }
                } else if ($columns[$i] == 'VAT') {
                    $VAT = $order->addedVAT;
                    if ($VAT != 0) {
                        $row[] = $VAT;
                    }
                } else if ($columns[$i] == 'isPaid') {
                    $status = $order->isPaid;
                    if ($status != 0) {
                        $row[] = $status;
                    }
                } else if ($columns[$i] == 'order id') {
                    $id = $order->id;
                    if ($id != 0) {
                        $row[] = $id;
                    }
                }
            }
            array_walk($row, 'filterData');
            $excelData .= implode("\t", array_values($row)) . "\n";
        }
        

        // Headers for download 
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$fileName\"");

        // Render excel data 
        echo $excelData;

        exit;
    }

    





}