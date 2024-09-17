<?php

namespace Stev\SmartBillClient;


use Stev\SmartBillClient\Exception\APIException;
use Stev\SmartBillClient\Exception\PermissionDeniedException;
use Stev\SmartBillClient\Model\Invoice;
use Stev\SmartBillClient\Model\Quote;
use Stev\SmartBillClient\Response\NewInvoiceResponse;
use Symfony\Component\Serializer\Serializer;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class SmartBillAPI
{

    protected string $baseUrl = 'https://ws.smartbill.ro/SBORO/api';

    public function __construct(
        protected readonly Serializer $serializer,
        protected readonly HttpClientInterface $httpClient
    ) {
    }

    public function sendInvoice(Invoice $invoice)
    {
        $httpClient = $this->initClient();

        try {
            $response = $httpClient->request(
                'POST',
                $this->baseUrl.'/invoice',
                [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json',
                    ],

                    'body' => $this->serializer->serialize($invoice, 'json'),
                ]
            );

            return $this->serializer->deserialize($response->getContent(true), NewInvoiceResponse::class, 'json');
        } catch (ClientExceptionInterface $e) {
            if ($e->getResponse()) {
                $content = $e->getResponse()->getContent(false);

                $decoded = $this->serializer->deserialize($content, 'array', 'json');

                if ($e->getResponse()->getStatusCode() === 401) {
                    throw new PermissionDeniedException($decoded['errorCode'], $decoded['errorText'], 'Autentificare esuata', 0, $e);
                }
            }

            throw new APIException($decoded['errorCode'], $decoded['errorText'], 'Eroare de client la apelul catre SmartBill', 0, $e);
        } catch (\Exception $e) {
            throw new APIException(null, null, 'Eroare de server la apelul catre SmartBill', 0, $e);
        }
    }

    private function initClient(): HttpClientInterface
    {
        return $this->httpClient->withOptions(['timeout' => 10, 'verify_host' => true, 'verify_peer' => true]);
    }

    public function sendQuote(Quote $quote)
    {
        $httpClient = $this->initClient();

        try {
            $response = $httpClient->request(
                'POST',
                $this->baseUrl.'/estimate',
                [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json',
                    ],

                    'body' => $this->serializer->serialize($quote, 'json'),
                ]
            );

            return $this->serializer->deserialize($response->getContent(true), NewInvoiceResponse::class, 'json');
        } catch (ClientExceptionInterface $e) {
            if ($e->getResponse()) {
                $content = $e->getResponse()->getContent(false);

                $decoded = $this->serializer->deserialize($content, 'array', 'json');

                if ($e->getResponse()->getStatusCode() === 401) {
                    throw new PermissionDeniedException($decoded['errorCode'], $decoded['errorText'], 'Autentificare esuata', 0, $e);
                }
            }

            throw new APIException($decoded['errorCode'], $decoded['errorText'], 'Eroare de client la apelul catre SmartBill', 0, $e);
        } catch (\Exception $e) {
            throw new APIException(null, null, 'Eroare de server la apelul catre SmartBill', 0, $e);
        }
    }

}
