<?php
include __DIR__ . '/cmsSidebar.php';

?>

<head>
    <link rel="stylesheet" href="/css/export.css">
</head>

<h1>Export information</h1>

<form id="exportForm" action="/cms/export" method="post">
    <h5>
        Export order information to csv or excel file.
    </h5>

    <div class="form-group">
        <label id="columns" for="exampleFormControlSelect1">Select columns</label><br>
        <input type="checkbox" id="vehicle1" name="total" value="total">
        <label for="Total">Total</label><br>
        <input type="checkbox" id="vehicle2" name="VAT" value="VAT">
        <label for="VAT">VAT</label><br>
        <input type="checkbox" id="vehicle3" name="isPaid" value="isPaid">
        <label for="vehicle3">Payment status</label><br>


        
        <label id="type" for="exampleFormControlSelect1">Select file type</label><br>
        <select id="typeSelect" class="btn btn-secondary dropdown-toggle" id="exampleFormControlSelect1" name="fileType">
            <option value="csv">CSV</option>
            <option value="excel">Excel</option>
        </select>
    </div>
    <button type="submit" name="export" class="btn btn-danger btn-sm delete" id="export">Export</button>
    <p>
        <?php echo $error ?>
    </p>
</form>



</div>