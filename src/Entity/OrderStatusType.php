<?php

declare(strict_types=1);

namespace Recruitment\Entity;


/**
 * Class OrderStatusType
 * @package Recruitment\Entity
 */
class OrderStatusType
{
    /** @ORM\Column(type="string") */
    private $orderStatus;

    /**
     * OrderStatusType constructor.
     * @param string $status
     */
    public function __construct(string $status)
    {
        if (!in_array($status, OrderSatusEnum::ENUM, true)) {
            throw new \LogicException(sprintf('Provided non existent order status: %s', $status));
        }

        $this->orderStatus = $status;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->orderStatus;
    }
}