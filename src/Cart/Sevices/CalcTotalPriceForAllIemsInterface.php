<?php

declare(strict_types=1);

namespace Recruitment\Cart\Sevices;

use Recruitment\Cart\Items;

/**
 * Interface CalcTotalPriceForAllIemsInterface
 * @package Recruitment\Cart\Sevices
 */
interface CalcTotalPriceForAllIemsInterface
{
    /**
     * @param Items $items
     * @return float
     */
    public function calcTotalPrice(Items $items): float;
}