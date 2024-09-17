<?php

namespace Stev\SmartBillClient\API;

use Stev\SmartBillClient\Exception\APIException;
use Stev\SmartBillClient\Exception\PermissionDeniedException;
use Stev\SmartBillClient\Response\ErrorResponse;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class BaseAPI
{

    protected string $baseUrl = 'https://ws.smartbill.ro/SBORO/api';

    public function __construct(
        protected readonly SerializerInterface $serializer,
        protected readonly HttpClientInterface $httpClient,
        #[\SensitiveParameter] private string $username,
        #[\SensitiveParameter] private string $password,
    ) {
    }

    protected function initClient(): HttpClientInterface
    {
        return $this->httpClient->withOptions(
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],
                'auth_basic' => [$this->username, $this->password],
                'timeout' => 10,
                'verify_host' => true,
                'verify_peer' => true,
            ]
        );
    }

    protected function serialize($object, array $serializerContext = []): string
    {
        return $this->serializer->serialize(
            $object,
            'json',
            array_merge_recursive(
                [
                    AbstractObjectNormalizer::SKIP_NULL_VALUES => true,
                    AbstractObjectNormalizer::SKIP_UNINITIALIZED_VALUES => true,
                    DateTimeNormalizer::FORMAT_KEY => 'Y-m-d',
                ],
                $serializerContext
            )
        );
    }

    protected function handleClientException(ClientExceptionInterface $clientException): void
    {
        if ($clientException->getResponse()) {
            $content = $clientException->getResponse()->getContent(false);

            $errorResponse = $this->serializer->deserialize($content, ErrorResponse::class, 'json');

            if ($clientException->getResponse()->getStatusCode() === 401) {
                throw new PermissionDeniedException('Autentificare esuata', $errorResponse, 0, $clientException);
            }
        }

        throw new APIException('Eroare de client la apelul catre SmartBill', $errorResponse, 0, $clientException);
    }
}