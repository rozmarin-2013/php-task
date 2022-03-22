<?php

declare(strict_types=1);

namespace Recruitment\Entity;

/**
 * Class ProductVatType
 * @package Recruitment\Entity
 */
class ProductVatType
{
    /** @ORM\Column(type="int") */
    private $productVat;

    public function __construct(int $productVat)
    {
        if (!in_array($productVat, ProductVatEnum::ENUM, true)) {
            throw new \InvalidArgumentException(sprintf('Provided non existent product vat: %s', $productVat));
        }

        $this->productVat = $productVat;
    }

    /**
     * @return int
     */
    public function getProductTax(): int
    {
        return $this->productVat;
    }
}
