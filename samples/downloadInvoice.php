<?php

$setup = require 'bootstrap.php';

/** @var \Stev\SmartBillClient\SmartBillAPI $smartBillClient */
$smartBillClient = $setup['smartBillClient'];

$pdf = $smartBillClient->getInvoiceAPI()->downloadInvoicePDF($_SERVER['SMART_BILL_VAT_NUMBER'], 'TEST', '0034');

file_put_contents(sys_get_temp_dir().'/invoice.pdf', $pdf);
