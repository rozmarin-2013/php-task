<?php

declare(strict_types=1);

namespace Recruitment\Cart\Exception;

use LogicException;
use Recruitment\Entity\Product;

class QuantityTooLowException extends LogicException
{
    public function __construct(Product $product)
    {
        $message = sprintf('Quantity for product %s is too lower', $product->getTitle());

        parent::__construct($message);
    }
}