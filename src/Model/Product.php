<?php

namespace Stev\SmartBillClient\Model;

class Product
{
    public ?string $code = null;
    public ?string $productDescription = null;
    public ?string $translatedName = null;
    public ?string $translatedMeasuringUnit = null;
    public string $currency = 'RON';
    public ?bool $isTaxIncluded = null;
    public ?string $taxName = null;
    public ?float $taxPercentage = null;
    public ?float $exchangeRate = null;
    public ?bool $saveToDb = null;
    public ?bool $isService = null;
    public ?string $warehouseName = null;
    protected bool $isDiscount = false;

    public function __construct(
        public string $name,
        public float $price,
        public float $quantity,
        public string $measuringUnitName
    ) {
    }

}
