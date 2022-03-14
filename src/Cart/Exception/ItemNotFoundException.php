<?php

declare(strict_types=1);

namespace Recruitment\Cart\Exception;

use LogicException;

class ItemNotFoundException extends LogicException
{
    public function __construct(int $index)
    {
        $message = sprintf('Item with index %d not found',$index);

        parent::__construct($message);
    }
}