<?php

declare(strict_types=1);

namespace Recruitment\Entity;

use Recruitment\Entity\Exception\InvalidUnitPriceException;

/**
 * Class Product
 * @package Recruitment\Entity
 */
class Product
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var float
     */
    private $price = 0;

    /**
     * @var int
     */
    private $minimumQuantity = 1;

    /**
     * @var ProductVatType
     */
    private $vat;

    /**
     * @var float
     */
    private $priceWithVat = 0;

    public function __construct()
    {
        $this->vat = (new ProductVatType(ProductVatEnum::DEFAULT));
    }

    /**
     * @param float $price
     */
    public function setUnitPrice(float $price)
    {
        if ($price <= 0) {
            throw new InvalidUnitPriceException();
        }

        $this->price = $price;
        $this->calcPriceWithTax();

        return $this;
    }

    /**
     * @return float
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getMinimumQuantity(): int
    {
        return $this->minimumQuantity;
    }

    /**
     * @param int $quantity
     * @return $this
     */
    public function setMinimumQuantity(int $quantity): self
    {
        if ($quantity < 1) {
            throw new \InvalidArgumentException("Quantity must be greater than 1");
        }

        $this->minimumQuantity = $quantity;

        return $this;
    }

    /**
     * @return int
     */
    public function getVat(): int
    {
        return $this->vat->getProductTax();
    }

    /**
     * @param ProductVatType $vat
     */
    public function setTax(ProductVatType $vat): self
    {
        $this->vat = $vat;

        $this->calcPriceWithTax();

        return $this;
    }

    /**
     * @return float
     */
    public function getPriceWithVat(): float
    {
        return $this->priceWithVat;
    }

    /**
     * @return void
     */
    private function calcPriceWithTax(): void
    {
        $this->priceWithVat = $this->price + ($this->price * $this->getVat()) /100;
    }
}
