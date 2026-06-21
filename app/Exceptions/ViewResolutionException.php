<?php

namespace App\Exceptions;

use RuntimeException;

class ViewResolutionException extends RuntimeException
{
    public function __construct($message = 'View for route not found.', $code = 404)
    {
        parent::__construct($message, $code);
    }
}
