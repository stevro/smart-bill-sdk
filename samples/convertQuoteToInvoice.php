<?php

use Stev\SmartBillClient\Model\Invoice;

$setup = require 'bootstrap.php';

/** @var \Stev\SmartBillClient\SmartBillAPI $smartBillClient */
$smartBillClient = $setup['smartBillClient'];

$invoice = new Invoice($_SERVER['SMART_BILL_VAT_NUMBER']);
$invoice->seriesName = 'TEST';
$invoice->issueDate = new \DateTime();

$invoice->useEstimateDetails = true;
$invoice->estimate = new \Stev\SmartBillClient\Model\Estimate('PROFORMA_TEST', '0081');

$invoice->payment = new \Stev\SmartBillClient\Model\InvoicePayment(119, 'Ordin plata');
$invoice->payment->isCash = false;

try {
    $response = $smartBillClient->getInvoiceAPI()->sendInvoice($invoice);
    dump($response);
} catch (\Stev\SmartBillClient\Exception\APIException $e) {
    dump($e->getMessage());
    dump($e->getPrevious()->getMessage());
    dump($e->getSmartBillResponse());
}