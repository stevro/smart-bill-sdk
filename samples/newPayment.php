<?php


$setup = require 'bootstrap.php';

/** @var \Stev\SmartBillClient\SmartBillAPI $smartBillClient */
$smartBillClient = $setup['smartBillClient'];

$payment = new \Stev\SmartBillClient\Model\Payment($_SERVER['SMART_BILL_VAT_NUMBER'], 119, 'Ordin plata');

$payment->issueDate = new \DateTime();
$payment->useInvoiceDetails = true;
$payment->invoicesList = [
    ['seriesName' => 'TEST', 'number' => '0034'],
];

try {
    $response = $smartBillClient->getPaymentAPI()->sendPayment($payment);
    dump($response);
} catch (\Stev\SmartBillClient\Exception\APIException $e) {
    dump($e->getMessage());
    dump($e->getPrevious()->getMessage());
    dump($e->getSmartBillResponse());
}