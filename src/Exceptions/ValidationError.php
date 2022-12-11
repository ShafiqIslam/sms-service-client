<?php

namespace Polygontech\SmsService\Exceptions;

use Exception;
use Throwable;

class ValidationError extends Exception
{
    public function __construct($message = "Some input might be wrong.", $code = 400, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
