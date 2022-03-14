<?php

declare(strict_types=1);

namespace Recruitment\Cart;

use Recruitment\Entity\Product;
use Recruitment\Entity\Order;

/**
 * Class Items
 * @package Recruitment\Cart
 */
class Items
{
    /**
     * @var array
     */
    private array $items = [];

    /**
     * @var Order
     */
    private Order $order;

    /**
     * Items constructor.
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * @param Product $product
     * @param int $count
     */
    public function addItem(Product $product, int $count)
    {
       if ($this->getItem($product->getId())) {
            $this->updateQuantityOnExistingProduct($product, $count);
       } else {
           $this->createItem($product, $count);
       }

       $this->notifyOrder();
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param int $index
     * @return Item|null
     */
    public function getItem(int $index): ?Item
    {
        return array_key_exists($index, $this->items) ? $this->items[$index] : null;
    }

    /**
     * @param Product $product
     */
    public function removeItem(Product $product): void
    {
        $index = $product->getId();

        if ($this->getItem($index)) {
            unset($this->items[$index]);
        }

        $this->notifyOrder();
    }

    /**
     * @param Product $product
     * @param int $count
     */
    private function updateQuantityOnExistingProduct(Product $product, int $count): void
    {
        if ($this->getItem($product->getId())) {
            $this->items[$product->getId()]->setQuantity($count);

            $this->notifyOrder();
        }
    }

    /**
     * @param Product $product
     * @param int $count
     */
    private function createItem(Product $product, int $count): void
    {
        $this->items[$product->getId()] = new Item($product, $count);

        $this->notifyOrder();
    }

    /**
     * @return array[]
     */
    public function getDataForView(): array
    {
        return array_map(
            function (Item $item){
                return [
                    'id' => $item->getId(),
                    'quantity' => $item->getQuantity(),
                    'total_price' => $item->getTotalPrice()
                ];
            },
            $this->items
        );
    }

    private function notifyOrder(): void
    {
        $this->order->calcTotalPrice();
    }
}