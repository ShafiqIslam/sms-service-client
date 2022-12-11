<?php

namespace Polygontech\SmsService\Exceptions;

use Throwable;
use Exception;

class SmsServiceNotWorking extends \Exception
{
    public function __construct($message = "Sms Service not working.", $code = 500, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
