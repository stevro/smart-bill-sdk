<?php

namespace Stev\SmartBillClient\Model;

class Payment
{

    public ?bool $isCash = null;

    public function __construct(public float $value, public string $paymentSeries, public string $type)
    {
    }

}