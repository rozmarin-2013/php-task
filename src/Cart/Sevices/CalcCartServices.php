<?php

declare(strict_types=1);

namespace Recruitment\Cart\Sevices;

use Recruitment\Cart\Items;

/**
 * Class CalcCartServices
 * @package Recruitment\Cart\Sevices
 */
class CalcCartServices implements CalcTotalPriceForAllItemsInterface
{
    /**
     * @param Items $items
     * @return float
     */
    public function calcTotalPrice(Items $items): float
    {
        $totalPrice = 0;

        foreach ($items->getItems() as $item) {
            $totalPrice += $item->getTotalPrice();
        }

        return $totalPrice;
    }

    /**
     * @param Items $items
     * @return float
     */
    public function calcTotalPriceGross(Items $items): float
    {
        $totalPriceGross = 0;

        foreach ($items->getItems() as $item) {
            $totalPriceGross += $item->getBrutoTotalPrice();
        }

        return $totalPriceGross;
    }
}
