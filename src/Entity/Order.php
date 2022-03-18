<?php

declare(strict_types=1);

namespace Recruitment\Entity;

use Recruitment\Cart\Sevices\CalcTotalPriceForAllIemsInterface;
use Recruitment\Cart\Items;

/**
 * Class Order
 * @package Recruitment\Entity
 */
class Order
{
    /**
     * @var int|string|null
     */
    private $id;

    /**
     * @var Items
     */
    private $items;

    /**
     * @var float|int
     */
    private $totalPrice = 0;

    /**
     * @var \Recruitment\Entity\OrderStatusType
     */
    private $orderStatusType;

    /**
     * @var CalcTotalPriceForAllIemsInterface
     */
    private $calcTotalPriceForAllIems;

    /**
     * Order constructor.
     * @param CalcTotalPriceForAllIemsInterface $calcTotalPriceForAllIems
     */
    public function __construct(CalcTotalPriceForAllIemsInterface $calcTotalPriceForAllIems)
    {
        $this->calcTotalPriceForAllIems = $calcTotalPriceForAllIems;
        $this->items = new Items($this);

        $orderId = 0;
        $orders = Orders::getInstance()->getOrders();

        if (count($orders)) {
            end($orders);
            $orderId = key($orders) +1;
        }

        $this->id = $orderId;
    }

    /**
     * @return array
     */
    public function getItems(): Items
    {
        return $this->items;
    }

    /**
     * @param array $items
     */
    public function setItems(Items $items): void
    {
        $this->items = $items;
        $this->calcTotalPrice();
    }

    /**
     * @return array
     */
    public function getDataForView(): array
    {
        return [
            'id' => $this->id,
            'items' => $this->items->getDataForView(),
            'total_price' => $this->totalPrice
        ];
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

    /**
     * @return float
     */
    public function calcTotalPrice(): float
    {
        $this->totalPrice = $this->calcTotalPriceForAllIems->calcTotalPrice($this->items);

        return $this->totalPrice;
    }

    /**
     *
     */
    public function checkout(): void
    {
        $this->setOrderStatusType(new OrderStatusType(OrderSatusEnum::CHECKOUT_IN_CART));
    }

    /**
     * @return \Recruitment\Entity\OrderStatusType
     */
    public function getOrderStatusType(): OrderStatusType
    {
        return $this->orderStatusType;
    }

    /**
     * @param \Recruitment\Entity\OrderStatusType $orderStatusType
     * @return $this
     */
    public function setOrderStatusType(OrderStatusType $orderStatusType): self
    {
        $this->orderStatusType = $orderStatusType;

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
     * @param float $totalPrice
     */
    public function setTotalPrice(float $totalPrice): void
    {
        $this->totalPrice = $totalPrice;
    }
}
