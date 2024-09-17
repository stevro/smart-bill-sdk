<?php

$setup = require 'bootstrap.php';


$smartBillClient = new \Stev\SmartBillClient\SmartBillAPI(
    $setup['serializer'],
    $setup['httpClient'],
    $_SERVER['SMART_BILL_USER'],
    $_SERVER['SMART_BILL_TOKEN']
);

$client = new \Stev\SmartBillClient\Model\Client('SC TEST SRL');
$client->email = 'test@test.com';
$client->county = 'Iasi';
$client->country = 'RO';
$client->vatCode = '22222';

$product = new \Stev\SmartBillClient\Model\Product('Test produs', 100, 1, 'buc');
$product->isTaxIncluded = false;
$product->taxPercentage = 19;
$product->isService = true;
$product->saveToDb = false;

$quote = new \Stev\SmartBillClient\Model\Quote('RO34150371');
$quote->seriesName = 'PROFORMA_TEST';
$quote->issueDate = new \DateTime();
$quote->dueDate = (new \DateTime())->modify('+30 days');
$quote->client = $client;
$quote->addProduct($product);

try {
    $response = $smartBillClient->sendQuote($quote);
    dump($response);
} catch (\Stev\SmartBillClient\Exception\APIException $e) {
    dump($e->getMessage());
    dump($e->getPrevious()->getMessage());
    dump($e->getSmartBillResponse());
}