<?php

declare(strict_types=1);

namespace Recruitment\Entity;

/**
 * Class Orders
 * @package Recruitment\Entity
 */
class Orders
{
    /**
     * @var array
     */
    private array $orders;

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
}