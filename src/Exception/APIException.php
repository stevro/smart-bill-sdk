<?php

namespace Stev\SmartBillClient\Exception;

use Stev\SmartBillClient\Response\ErrorResponse;

class APIException extends \Exception
{

    public function __construct(
        string $message = "Eroare la comunicarea cu API-ul SmartBill",
        protected readonly ?ErrorResponse $smartBillResponse = null,
        int $code = 0,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

    public function getSmartBillResponse(): ?ErrorResponse
    {
        return $this->smartBillResponse;
    }

}
