<?php

namespace Stev\SmartBillClient\Model;

use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

class Quote
{
    public ?Client $client = null;


    public ?\DateTime $issueDate = null;
    public ?\DateTime $dueDate = null;
    public ?\DateTime $deliveryDate = null;
    public ?string $seriesName = null;
    public string $currency = 'RON';
    public float $exchangeRate = 1;
    public ?string $paymentUrl = null;
    public string $language = 'RO';
    public int $precision = 2;
    public bool $isDraft = false;
    public bool $useIntraCif = false;
    public ?string $issuerCnp = null;
    public ?string $issuerName = null;
    public ?string $aviz = null;
    public ?string $mentions = null;
    public ?string $observations = null;
    public ?string $delegateName = null;
    public ?string $delegateIdentityCard = null;
    public ?string $delegateAuto = null;
    public ?\DateTime $paymentDate = null;
    public ?bool $sendEmail = null;
    public ?Email $email = null;
    public array $products = [];

    public function __construct(public string $companyVatCode)
    {
    }

    public function addProduct(Product $product): self
    {
        if (!in_array($product, $this->products, true)) {
            $this->products[] = $product;
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if (false !== ($key = array_search($product, $this->products, true))) {
            unset($this->products[$key]);
        }

        return $this;
    }

    public function getProducts(): array
    {
        return $this->products;
    }
}