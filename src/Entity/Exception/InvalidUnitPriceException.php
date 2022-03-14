<?php

declare(strict_types=1);

namespace Recruitment\Entity\Exception;

use LogicException;

class InvalidUnitPriceException extends LogicException
{
    public function __construct()
    {
        $message = sprintf('Price must be greater than 1');

        parent::__construct($message);
    }
}