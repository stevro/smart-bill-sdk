<?php

namespace Stev\SmartBillClient\Model;

class Client
{

    public ?string $vatCode = null;
    public ?string $address = null;
    public ?string $regCom = null;
    public ?string $contact = null;
    public ?string $phone = null;
    public ?string $city = null;
    public ?string $county = null;
    public ?string $country = null;
    public ?string $email = null;
    public ?string $bank = null;
    public ?string $iban = null;
    public ?bool $isTaxPayer = null;
    public bool $saveToDb = false;

    public function __construct(public string $name)
    {
    }
}
