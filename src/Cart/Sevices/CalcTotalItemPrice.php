<?php

declare(strict_types=1);

namespace Recruitment\Cart\Sevices;

use Recruitment\Cart\Item;

/**
 * Class CalcTotalItemPrice
 * @package Recruitment\Cart\Sevices
 */
class CalcTotalItemPrice
{
    /**
     * @param Item $item
     * @return float|int
     */
    public function calcTotalPrice(Item $item)
    {
        return $item->getQuantity() * $item->getProduct()->getPrice();
    }
}