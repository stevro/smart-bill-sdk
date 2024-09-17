<?php

namespace Stev\SmartBillClient\API;

use Stev\SmartBillClient\Exception\APIException;
use Stev\SmartBillClient\Model\Payment;
use Stev\SmartBillClient\Response\NewPaymentResponse;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;

class PaymentAPI extends BaseAPI
{
    public function createPayment(Payment $payment, array $serializerContext = []): NewPaymentResponse
    {
        $httpClient = $this->initClient();

        $body = $this->serialize($payment, $serializerContext);

        try {
            $response = $httpClient->request(
                'POST',
                $this->baseUrl.'/payment',
                [
                    'body' => $body,
                ]
            );

            return $this->serializer->deserialize($response->getContent(true), NewPaymentResponse::class, 'json');
        } catch (ClientExceptionInterface $e) {
            $this->handleClientException($e);
        } catch (\Exception $e) {
            throw new APIException('Eroare de server la apelul catre SmartBill', null, 0, $e);
        }
    }
}