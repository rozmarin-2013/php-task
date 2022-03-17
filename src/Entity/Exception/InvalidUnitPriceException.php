<?php

declare(strict_types=1);

namespace Recruitment\Entity\Exception;

class InvalidUnitPriceException extends \InvalidArgumentException
{
    public function __construct()
    {
        $message = sprintf('Price must be greater than 1');

        parent::__construct($message);
    }
}