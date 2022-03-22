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
    private $items = [];

    /**
     * @var Order
     */
    private $order;

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
        $item = $this->getItemByProduct($product);

        if ($this->getItemByProduct($product)) {
            $this->updateQuantityOnExistingProduct($product, $item->getQuantity() + $count);
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
    public function getItemByProduct(Product $product): ?Item
    {
        $items = $this->items;

        /** @var Item $item */
        foreach ($items as $item) {
            if ($item->getProduct()->getId() === $product->getId()) {
                return $item;
            }
        }

        return null;
    }

    /**
     * @param int $index
     * @return Item|null
     */
    public function getItem(int $index): ?Item
    {
        $items = $this->items;

        return isset($items[$index]) ? $items[$index] : null;
    }

    /**
     * @param Product $product
     */
    public function removeItem(Product $product): void
    {
        $items = $this->items;

        /**
         * @var int $key
         * @var  Item $item
         */
        foreach ($items as $key => $item) {
            if ($item->getProduct()->getId() === $product->getId()) {
                array_splice($this->items, $key, 1);
                break;
            }
        }

        $this->notifyOrder();
    }

    /**
     * @param Product $product
     * @param int $count
     */
    public function updateQuantityOnExistingProduct(Product $product, int $count): void
    {
        $item = $this->getItemByProduct($product);

        if ($item) {
            $item->setQuantity($count);
            $this->notifyOrder();
        }
    }

    /**
     * @param Product $product
     * @param int $count
     */
    private function createItem(Product $product, int $count): void
    {
        $index = 0;
        if (count($this->items)) {
            end($this->items);
            $index = key($this->items) + 1;
        }

        $this->items[$index] = new Item($product, $count);

        $this->notifyOrder();
    }

    /**
     * @return array[]
     */
    public function getDataForView(): array
    {
        return array_map(
            function (Item $item) {
                return [
                    'id' => $item->getProduct()->getId(),
                    'quantity' => $item->getQuantity(),
                    'total_price' => $item->getTotalPrice(),
                    'vat' => $item->getProduct()->getVat(),
                    'total_price_gross' => $item->getBrutoTotalPrice()
                ];
            },
            $this->items
        );
    }

    private function notifyOrder(): void
    {
        $this->order->calcAllPrice();
    }
}
