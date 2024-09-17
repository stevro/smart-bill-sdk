<?php

namespace Stev\SmartBillClient\API;

use Stev\SmartBillClient\Exception\APIException;
use Stev\SmartBillClient\Model\Quote;
use Stev\SmartBillClient\Response\NewQuoteResponse;
use Stev\SmartBillClient\Response\QuoteStateResponse;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;

class QuoteAPI extends BaseAPI
{
    public function createQuote(Quote $quote, array $serializerContext = []): NewQuoteResponse
    {
        $httpClient = $this->initClient();

        $body = $this->serialize($quote, $serializerContext);

        try {
            $response = $httpClient->request(
                'POST',
                $this->baseUrl.'/estimate',
                [
                    'body' => $body,
                ]
            );

            return $this->serializer->deserialize($response->getContent(true), NewQuoteResponse::class, 'json');
        } catch (ClientExceptionInterface $e) {
            $this->handleClientException($e);
        } catch (\Exception $e) {
            throw new APIException('Eroare de server la apelul catre SmartBill', null, 0, $e);
        }
    }

    public function downloadQuotePDF(string $vatNumber, string $seriesName, string $number): string
    {
        $httpClient = $this->initClient();

        try {
            $response = $httpClient->request(
                'GET',
                $this->baseUrl.'/estimate/pdf',
                [
                    'headers' => [
                        'Accept' => 'application/octet-stream',
                    ],
                    'query' => [
                        'cif' => $vatNumber,
                        'seriesname' => $seriesName,
                        'number' => $number,
                    ],
                ]
            );

            return $response->getContent(true);
        } catch (ClientExceptionInterface $e) {
            $this->handleClientException($e);
        } catch (\Exception $e) {
            throw new APIException('Eroare de server la apelul catre SmartBill', null, 0, $e);
        }
    }

    public function getQuoteState(string $vatNumber, string $seriesName, string $number): QuoteStateResponse
    {
        $httpClient = $this->initClient();

        try {
            $response = $httpClient->request(
                'GET',
                $this->baseUrl.'/estimate/invoices',
                [
                    'query' => [
                        'cif' => $vatNumber,
                        'seriesname' => $seriesName,
                        'number' => $number,
                    ],
                ]
            );

            return $this->serializer->deserialize($response->getContent(true), QuoteStateResponse::class, 'json');
        } catch (ClientExceptionInterface $e) {
            $this->handleClientException($e);
        } catch (\Exception $e) {
            throw new APIException('Eroare de server la apelul catre SmartBill', null, 0, $e);
        }
    }
}