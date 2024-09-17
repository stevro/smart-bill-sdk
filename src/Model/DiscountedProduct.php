<?php

namespace Stev\SmartBillClient\Model;

class DiscountedProduct extends Product
{
    public ?int $numberOfItems = null;
    public ?string $discountType = null;
    public ?float $discountPercentage = null;
    public ?float $discountValue = null;
    protected bool $isDiscount = true;
}