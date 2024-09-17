<?php

namespace Stev\SmartBillClient\Exception;

class APIException extends \Exception
{

    public function __construct(public string $errorCode = "", public string $errorText="", string $message = "", int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}
