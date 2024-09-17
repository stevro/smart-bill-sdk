<?php

namespace Stev\SmartBillClient\Model;

class Estimate
{

    public ?string $number = null;
    public bool $useStock = false;
    public ?string $paymentUrl = null;

    public function __construct(public string $seriesName)
    {
    }
}
