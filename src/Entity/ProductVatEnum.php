<?php

declare(strict_types=1);

namespace Recruitment\Entity;

/**
 * Class ProductVatEnum
 * @package Recruitment\Entity
 */
class ProductVatEnum
{
    public const TAX_0 = 0;
    public const TAX_5 = 5;
    public const TAX_8 = 8;
    public const TAX_23 = 23;

    public const DEFAULT = self::TAX_0;

    public const ENUM = [
        self::TAX_0,
        self::TAX_5,
        self::TAX_8,
        self::TAX_23
    ];
}
