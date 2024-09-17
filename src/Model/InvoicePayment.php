<?php

namespace Stev\SmartBillClient\Model;

class InvoicePayment
{

    public ?string $paymentSeries = null;
    public ?bool $isCash = null;

    public function __construct(public float $value, public string $type)
    {
    }

}