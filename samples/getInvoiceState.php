<?php

$setup = require 'bootstrap.php';

/** @var \Stev\SmartBillClient\SmartBillAPI $smartBillClient */
$smartBillClient = $setup['smartBillClient'];

try {
    $response = $smartBillClient->getInvoiceAPI()->getInvoiceState($_SERVER['SMART_BILL_VAT_NUMBER'], 'TEST', '0035');
    dump($response);
} catch (\Stev\SmartBillClient\Exception\APIException $e) {
    dump($e->getMessage());
    dump($e->getPrevious()->getMessage());
    dump($e->getSmartBillResponse());
}
