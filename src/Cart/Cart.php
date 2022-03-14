<?php

declare(strict_types=1);

namespace Recruitment\Cart;

use Recruitment\Cart\Exception\ItemNotFoundException;
use Recruitment\Entity\Order;
use Recruitment\Entity\Orders;
use Recruitment\Entity\Product;
use Recruitment\Cart\Sevices\CalcCartServices;

/**
 * Class Cart
 * @package Recruitment\Cart
 */
class Cart
{
    /**
     * @var mixed|Orders
     */
    private Orders $orders;

    /**
     * @var Order
     */
    private Order $order;

    /**
     * Cart constructor.
     * @param int|null $orderId
     */
    public function __construct(?int $orderId)
    {
        $this->orders = Orders::getInstance();
        $this->order = $this->orders->getOrder($orderId) ?? new Order(new CalcCartServices());
        $this->orders->addOrder($this->order);
    }

    /**
     * @param Product $product
     * @param int $count
     * @return $this
     */
    public function addProduct(Product $product, int $count): self
    {
        $this->order->getItems()->addItem($product, $count);

        return $this;
    }

    /**
     * @param Product $product
     */
    public function removeProduct(Product $product): void
    {
        $this->order->getItems()->removeItem($product);
    }

    /**
     * @param Product $product
     * @param int $count
     * @return $this
     */
    public function setQuantity(Product $product, int $count): self
    {
        $this->addProduct($product, $count);

        return $this;
    }

    /**
     * @param int $index
     * @return Item
     */
    public function getItem(int $index): Item
    {
        $item = $this->order->getItems()->getItem($index);

        if (!$item) {
            throw new ItemNotFoundException($index);
        }

        return $item;
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->order->getItems()->getItems();
    }

    /**
     * @return float
     */
    public function getTotalPrice(): float
    {
        return $this->order->getTotalPrice();
    }

    /**
     * @param int $orderId
     * @return Order|null
     */
    public function checkout(int $orderId): ?Order
    {
        $order = $this->orders->getOrder($orderId);

        if ($order) {
            $order->checkout();
        }

        return $order;
    }
}