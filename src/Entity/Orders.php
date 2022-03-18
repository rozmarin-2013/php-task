<?php

declare(strict_types=1);

namespace Recruitment\Entity;

use Recruitment\Cart\Items;
use Recruitment\Cart\Sevices\CalcCartServices;

/**
 * Class Orders
 * @package Recruitment\Entity
 */
class Orders
{
    /**
     * @var array
     */
    private $orders = [];

    /**
     * @var array
     */
    private static $instances = [];

    /**
     * Orders constructor.
     */
    protected function __construct() { }

    protected function __clone() { }

    /**
     * @throws \Exception
     */
    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize singleton");
    }

    /**
     * @return Orders
     */
    public static function getInstance(): Orders
    {
        $subclass = static::class;
        if (!isset(self::$instances[$subclass])) {
            self::$instances[$subclass] = new static();
        }
        return self::$instances[$subclass];
    }

    /**
     * @param Order $order
     */
    public function addOrder(Order $order): void
    {
        $this->orders[$order->getId()] = $order;
    }

    /**
     * @return array
     */
    public function getOrders(): array
    {
        return $this->orders;
    }

    /**
     * @param int $index
     * @return Order|null
     */
    public function getOrder(int $index): ?Order
    {
        return array_key_exists($index, $this->orders) ? $this->orders[$index] : null;
    }

    /**
     * @param int $index
     * @param Order $order
     */
    public function cloneOrder(int $index, Order $order): void
    {
        if (array_key_exists($index, $this->orders)) {
            $this->orders[$index] = $order;
        }
    }


    public function addTestOrder(): void
    {
        if (!$this->getOrder(7)) {
            $order = new Order(new CalcCartServices());
            $order->setId(7);

            $items = new Items($order);
            $items->addItem((new Product())->setId(1)->setUnitPrice(15000), 1);
            $items->addItem((new Product())->setId(2)->setUnitPrice(10000), 2);

            $order->setItems($items);
            $this->addOrder($order);
        }
    }
}
