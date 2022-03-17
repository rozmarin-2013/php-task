<?php

declare(strict_types=1);

namespace Recruitment\Cart;

use Recruitment\Cart\Exception\QuantityTooLowException;
use Recruitment\Cart\Sevices\CalcTotalItemPrice;
use Recruitment\Entity\Product;

/**
 * Class Item
 * @package Recruitment\Cart
 */
class Item
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var Product
     */
    private $product;

    /**
     * @var int
     */
    private $quantity;

    /**
     * @var int
     */
    private $totalPrice;

    /**
     * @var CalcTotalItemPrice
     */
    private $calcTotalItemPrice;

    /**
     * Item constructor.
     * @param Product $product
     * @param int $quantity
     */
    public function __construct(Product $product, int $quantity)
    {
        $this->product = $product;

        if ($product->getMinimumQuantity() > $quantity) {
            throw new QuantityTooLowException($this->product);
        }

        $this->quantity = $quantity;
        $this->calcTotalItemPrice = new CalcTotalItemPrice();

        $this->totalPrice = $this->calcTotalItemPrice->calcTotalPrice($this);
    }

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     * @return $this
     */
    public function setQuantity(int $quantity): self
    {
        if ($this->product->getMinimumQuantity() > $quantity) {
            throw new QuantityTooLowException($this->product);
        }

        $this->quantity = $quantity;

        if($this->product->getPrice() && $this->getQuantity()) {
            $this->totalPrice = $this->calcTotalItemPrice->calcTotalPrice($this);
        }

        return $this;
    }

    /**
     * @return float
     */
    public function getTotalPrice(): float
    {
        return $this->totalPrice;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }
}
