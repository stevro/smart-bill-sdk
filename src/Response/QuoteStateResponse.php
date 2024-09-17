<?php

namespace Stev\SmartBillClient\Response;

use Stev\SmartBillClient\Dto\BaseInvoice;

class QuoteStateResponse extends BaseResponse
{

    public bool $areInvoicesCreated = false;
    protected array $invoices = [];

    public function addInvoice(BaseInvoice $invoice): static
    {
        $this->invoices[] = $invoice;

        return $this;
    }

    public function removeInvoice(BaseInvoice $invoice): static
    {
        if (false !== ($key = array_search($invoice, $this->invoices, true))) {
            unset($this->invoices[$key]);
        }

        return $this;
    }

    public function getInvoices(): array
    {
        return $this->invoices;
    }
}