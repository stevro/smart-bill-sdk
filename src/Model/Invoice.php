<?php

namespace Stev\SmartBillClient\Model;

use Symfony\Component\Serializer\Annotation as Serializer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

class Invoice
{

    public ?Client $client = null;

    #[Serializer\Context([DateTimeNormalizer::FORMAT_KEY => 'Y-m-d'])]
    public ?\DateTime $issueDate = null;
    #[Serializer\Context([DateTimeNormalizer::FORMAT_KEY => 'Y-m-d'])]
    public ?\DateTime $dueDate = null;
    #[Serializer\Context([DateTimeNormalizer::FORMAT_KEY => 'Y-m-d'])]
    public ?\DateTime $deliveryDate = null;
    public ?string $seriesName = null;
    public string $currency = 'RON';
    public float $exchangeRate = 1;
    public ?string $paymentUrl = null;
    public string $language = 'RO';
    public int $precision = 2;
    public bool $isDraft = false;
    public bool $useIntraCif = false;
    public bool $useStock = false;
    public bool $useEstimateDetails = false;
    public ?Estimate $estimate = null;
    public bool $usePaymentTax = false;
    public ?float $paymentBase = null;
    public ?float $colectedTax = null;
    public ?float $paymentTotal = null;
    public ?string $issuerCnp = null;
    public ?string $issuerName = null;
    public ?string $aviz = null;
    public ?string $mentions = null;
    public ?string $observations = null;
    public ?string $delegateName = null;
    public ?string $delegateIdentityCard = null;
    public ?string $delegateAuto = null;
    #[Serializer\Context([DateTimeNormalizer::FORMAT_KEY => 'Y-m-d'])]
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
