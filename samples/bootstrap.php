<?php

require __DIR__.'/../vendor/autoload.php';

use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;

#setup code
#not needed if you use a framework like symfony/laravel/etc.
(new DotEnv())->loadEnv(__DIR__.'/../.env');

$serializer = new \Symfony\Component\Serializer\Serializer(
    normalizers: [
        new \Symfony\Component\Serializer\Normalizer\ArrayDenormalizer(),
        new \Symfony\Component\Serializer\Normalizer\DateTimeNormalizer(),
        new \Symfony\Component\Serializer\Normalizer\ObjectNormalizer(null, null, null, new ReflectionExtractor()),
    ],
    encoders: [new \Symfony\Component\Serializer\Encoder\JsonEncoder()]
);

$httpClient = HttpClient::create();

$smartBillClient = new \Stev\SmartBillClient\SmartBillAPI(
    $serializer,
    $httpClient,
    $_SERVER['SMART_BILL_USER'],
    $_SERVER['SMART_BILL_TOKEN']
);

return [
    'smartBillClient' => $smartBillClient,
];

#end of setup code