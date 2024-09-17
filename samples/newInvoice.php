<?php

require __DIR__.'/../vendor/autoload.php';

use Stev\SmartBillClient\Model\Invoice;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\HttpClient\HttpClient;

#setup code
#not needed if you use a framework like symfony/laravel/etc.
(new DotEnv())->loadEnv(__DIR__.'/../.env');

$serializer = new \Symfony\Component\Serializer\Serializer(
    [
        new \Symfony\Component\Serializer\Normalizer\DateTimeNormalizer(),
        new \Symfony\Component\Serializer\Normalizer\ObjectNormalizer(),

    ],
    [new \Symfony\Component\Serializer\Encoder\JsonEncoder()]
);

$httpClient = HttpClient::create();

#end of setup code

#start of user land code
#this is what you need in your project


$smartBillClient = new \Stev\SmartBillClient\SmartBillAPI($serializer, $httpClient, $_SERVER['SMART_BILL_USER'], $_SERVER['SMART_BILL_TOKEN']);

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

$invoice = new Invoice('RO34150371');
$invoice->seriesName = 'TEST';
$invoice->issueDate = new \DateTime();
$invoice->dueDate = (new \DateTime())->modify('+30 days');
$invoice->client = $client;
$invoice->addProduct($product);

try {
    $response = $smartBillClient->sendInvoice($invoice);
    dump($response);
} catch (\Stev\SmartBillClient\Exception\APIException $e) {
    dump($e->getMessage());
    dump($e->getPrevious()->getMessage());
    dump($e->getSmartBillResponse());
}