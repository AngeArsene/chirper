<?php

namespace App\Exceptions;

use RuntimeException;

class RouteNotNamedException extends RuntimeException
{
    public function __construct($message = 'Current route has no name.')
    {
        parent::__construct($message);
    }
}
