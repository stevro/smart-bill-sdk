<?php

namespace Stev\SmartBillClient\Response;

class InvoiceStateResponse extends BaseResponse
{
    
    public ?float $invoiceTotalAmount = null;
    public ?float $paidAmount = null;
    public ?float $unpaidAmount = null;


}
