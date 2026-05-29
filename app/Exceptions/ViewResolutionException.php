<?php

namespace App\Exceptions;

use RuntimeException;

class ViewResolutionException extends RuntimeException
{
    public function __construct($message = 'View for route not found.')
    {
        parent::__construct($message);
    }
}
