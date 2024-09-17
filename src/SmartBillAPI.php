<?php

namespace Stev\SmartBillClient;


use Stev\SmartBillClient\API\InvoiceAPI;
use Stev\SmartBillClient\API\PaymentAPI;
use Stev\SmartBillClient\API\QuoteAPI;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class SmartBillAPI
{

    private ?InvoiceAPI $invoiceAPI = null;
    private ?QuoteAPI $quoteAPI = null;
    private ?PaymentAPI $paymentAPI = null;

    public function __construct(
        protected readonly SerializerInterface $serializer,
        protected readonly HttpClientInterface $httpClient,
        #[\SensitiveParameter] private string $username,
        #[\SensitiveParameter] private string $password,
    ) {
    }

    public function getInvoiceAPI(): InvoiceAPI
    {
        if (!$this->invoiceAPI) {
            $this->invoiceAPI = new InvoiceAPI($this->serializer, $this->httpClient, $this->username, $this->password);
        }

        return $this->invoiceAPI;
    }

    public function getQuoteAPI(): QuoteAPI
    {
        if (!$this->quoteAPI) {
            $this->quoteAPI = new QuoteAPI($this->serializer, $this->httpClient, $this->username, $this->password);
        }

        return $this->quoteAPI;
    }

    public function getPaymentAPI(): PaymentAPI
    {
        if (!$this->paymentAPI) {
            $this->paymentAPI = new PaymentAPI($this->serializer, $this->httpClient, $this->username, $this->password);
        }

        return $this->paymentAPI;
    }


}
