<?php

require __DIR__.'/../vendor/autoload.php';

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

return [
    'httpClient' => $httpClient,
    'serializer' => $serializer,
];

#end of setup code