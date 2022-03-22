<?php

declare(strict_types=1);

namespace Recruitment\Cart\Sevices;

use Recruitment\Cart\Items;

/**
 * Interface CalcTotalPriceForAllItemsInterface
 * @package Recruitment\Cart\Sevices
 */
interface CalcTotalPriceForAllItemsInterface
{
    /**
     * @param Items $items
     * @return float
     */
    public function calcTotalPrice(Items $items): float;

    /**
     * @param Items $items
     * @return float
     */
    public function calcTotalPriceGross(Items $items): float;
}
