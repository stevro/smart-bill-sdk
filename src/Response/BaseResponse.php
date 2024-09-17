<?php

namespace Stev\SmartBillClient\Response;

class BaseResponse
{
    public ?string $url = null;
    public ?string $series = null;
    public ?string $number = null;
    public ?string $message = null;
    public ?string $errorText = null;
}