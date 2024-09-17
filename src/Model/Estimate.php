<?php

namespace Stev\SmartBillClient\Model;

class Estimate
{

    public function __construct(public string $seriesName, public string $number)
    {
    }
}
