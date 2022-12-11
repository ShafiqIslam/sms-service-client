<?php

namespace Polygontech\SmsService\Facades;

use Illuminate\Support\Facades\Facade;
use Polygontech\CommonHelpers\Mobile\BDMobile;
use Polygontech\SmsService\Responses\BulkSmsChargeEstimation;
use Polygontech\SmsService\Responses\BulkSmsResponse;
use Polygontech\SmsService\Responses\SingleSmsChargeEstimation;
use Polygontech\SmsService\Responses\SingleSmsResponse;
use Polygontech\SmsService\Feature;

/**
 * @method static SingleSmsResponse | BulkSmsResponse shoot(Feature $feature, array | BDMobile $recipients, string $message)
 * @method static SingleSmsChargeEstimation | BulkSmsChargeEstimation estimateCharge(Feature $feature, array | BDMobile $recipients, string $message)
 *
 * @see \Polygontech\SmsService\Sms
 */
class Sms extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "sms.service";
    }
}
