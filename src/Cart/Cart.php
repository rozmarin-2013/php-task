<?php

declare(strict_types=1);

namespace Recruitment\Cart;

use OutOfBoundsException;
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
    private $orders;

    /**
     * @var Order
     */
    private $order;

    /**
     * Cart constructor.
     * @param int|null $orderId
     */
    public function __construct(?int $orderId = null)
    {
        $this->orders = Orders::getInstance();
        $this->orders->addTestOrder();
        $this->order = ($orderId) ? $this->orders->getOrder($orderId) : new Order(new CalcCartServices());
        $this->orders->addOrder($this->order);
    }

    /**
     * @param Product $product
     * @param int $count
     * @return $this
     */
    public function addProduct(Product $product, ?int $count = null): self
    {

        $this->order->getItems()->addItem(
            $product,
            $count ?? $product->getMinimumQuantity()
        );
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
        if (count($this->order->getItems()->getItems())) {
            $this->order->getItems()->updateQuantityOnExistingProduct($product, $count);
        } else {
            $this->addProduct($product, $count);
        }

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
            throw new OutOfBoundsException(sprintf('Item#%d not found', $index), -1);
        }

        return $item;
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return ($this->order) ? $this->order->getItems()->getItems() : [];
    }

    /**
     * @return float
     */
    public function getTotalPrice(): float
    {
        return ($this->order) ? $this->order->getTotalPrice() : 0;
    }

    /**
     * @param int $orderId
     * @return Order|null
     */
    public function checkout(int $orderId): ?Order
    {
        $order = clone($this->orders->getOrder($orderId));

        if ($order) {
            $this->orders->cloneOrder($orderId, $order);
            $this->order = new Order(new CalcCartServices());
        }

        return $order;
    }

    /**
     * @return Orders
     */
    public function getOrders(): Orders
    {
        return $this->orders;
    }
}
