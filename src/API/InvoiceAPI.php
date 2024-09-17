<?php

namespace Stev\SmartBillClient\API;

use Stev\SmartBillClient\Exception\APIException;
use Stev\SmartBillClient\Model\Invoice;
use Stev\SmartBillClient\Response\InvoiceStateResponse;
use Stev\SmartBillClient\Response\NewInvoiceResponse;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;

class InvoiceAPI extends BaseAPI
{
   
    public function createInvoice(Invoice $invoice, array $serializerContext = []): NewInvoiceResponse
    {
        $httpClient = $this->initClient();

        $body = $this->serialize($invoice, $serializerContext);

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
            $this->handleClientException($e);
        } catch (\Exception $e) {
            throw new APIException('Eroare de server la apelul catre SmartBill', null, 0, $e);
        }
    }

    public function downloadInvoicePDF(string $vatNumber, string $seriesName, string $number): string
    {
        $httpClient = $this->initClient();

        try {
            $response = $httpClient->request(
                'GET',
                $this->baseUrl.'/invoice/pdf',
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

    public function getInvoiceState(string $vatNumber, string $seriesName, string $number): InvoiceStateResponse
    {
        $httpClient = $this->initClient();

        try {
            $response = $httpClient->request(
                'GET',
                $this->baseUrl.'/invoice/paymentstatus',
                [
                    'query' => [
                        'cif' => $vatNumber,
                        'seriesname' => $seriesName,
                        'number' => $number,
                    ],
                ]
            );

            return $this->serializer->deserialize($response->getContent(true), InvoiceStateResponse::class, 'json');
        } catch (ClientExceptionInterface $e) {
            $this->handleClientException($e);
        } catch (\Exception $e) {
            throw new APIException('Eroare de server la apelul catre SmartBill', null, 0, $e);
        }
    }
}