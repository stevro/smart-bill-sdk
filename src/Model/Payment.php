<?php

namespace Stev\SmartBillClient\Model;

/**
 * @see https://api.smartbill.ro/#!/Incasari/addPaymentPublicApi
 */
class Payment
{
    public ?Client $client = null;

    public ?\DateTime $issueDate = null;
    public ?string $seriesName = null;
    public ?string $currency = null;
    public ?string $language = null;
    public ?float $exchangeRate = null;
    public ?int $precision = null;
    public ?string $text = null;
    public ?string $translatedText = null;
    public ?string $observation = null;
    public bool $isDraft = false;
    public bool $isCash = false;
    public bool $useInvoiceDetails = false;
    public ?array $invoicesList = null;

    public function __construct(public string $companyVatCode, public float $value, public string $type)
    {
    }
}