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
    private $price;

    /**
     * @var int
     */
    private $minimumQuantity = 1;

    /**
     * @param float $price
     */
    public function setUnitPrice(float $price)
    {
        if ($price <= 0) {
            throw new InvalidUnitPriceException();
        }

        $this->price = $price;

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
}
