<?php

namespace Stev\SmartBillClient;


use Stev\SmartBillClient\Exception\APIException;
use Stev\SmartBillClient\Exception\PermissionDeniedException;
use Stev\SmartBillClient\Model\Invoice;
use Stev\SmartBillClient\Model\Quote;
use Stev\SmartBillClient\Response\ErrorResponse;
use Stev\SmartBillClient\Response\NewInvoiceResponse;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class SmartBillAPI
{

    protected string $baseUrl = 'https://ws.smartbill.ro/SBORO/api';

    public function __construct(
        protected readonly Serializer $serializer,
        protected readonly HttpClientInterface $httpClient,
        #[\SensitiveParameter] private string $username,
        #[\SensitiveParameter] private string $password,
    ) {
    }

    public function sendInvoice(Invoice $invoice, array $serializerContext = [])
    {
        $httpClient = $this->initClient();

        $body = $this->serializer->serialize(
            $invoice,
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

        try {
            $response = $httpClient->request(
                'POST',
                $this->baseUrl.'/invoice',
                [

                    'body' => $body,
                ]
            );

            return $this->serializer->deserialize($response->getContent(true), NewInvoiceResponse::class, 'json');
        } catch (ClientExceptionInterface $e) {
            if ($e->getResponse()) {
                $content = $e->getResponse()->getContent(false);

                $errorResponse = $this->serializer->deserialize($content, ErrorResponse::class, 'json');

                if ($e->getResponse()->getStatusCode() === 401) {
                    throw new PermissionDeniedException('Autentificare esuata', $errorResponse, 0, $e);
                }
            }

            throw new APIException('Eroare de client la apelul catre SmartBill', $errorResponse, 0, $e);
        } catch (\Exception $e) {
            throw new APIException('Eroare de server la apelul catre SmartBill', null, 0, $e);
        }
    }

    private function initClient(): HttpClientInterface
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

    public function sendQuote(Quote $quote, array $serializerContext = [])
    {
        $httpClient = $this->initClient();

        $body = $this->serializer->serialize(
            $quote,
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

        try {
            $response = $httpClient->request(
                'POST',
                $this->baseUrl.'/estimate',
                [
                    'body' => $body,
                ]
            );

            return $this->serializer->deserialize($response->getContent(true), NewInvoiceResponse::class, 'json');
        } catch (ClientExceptionInterface $e) {
            if ($e->getResponse()) {
                $content = $e->getResponse()->getContent(false);

                $errorResponse = $this->serializer->deserialize($content, ErrorResponse::class, 'json');

                if ($e->getResponse()->getStatusCode() === 401) {
                    throw new PermissionDeniedException('Autentificare esuata', $errorResponse, 0, $e);
                }
            }

            throw new APIException('Eroare de client la apelul catre SmartBill', $errorResponse, 0, $e);
        } catch (\Exception $e) {
            throw new APIException('Eroare de server la apelul catre SmartBill', null, 0, $e);
        }
    }

}
