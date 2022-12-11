<?php

namespace Polygontech\SmsService;

use Polygontech\CommonHelpers\Mobile\BDMobile;
use Polygontech\SmsService\Inputs\BulkSms;
use Polygontech\SmsService\Inputs\SingleSms;
use Polygontech\SmsService\Inputs\Feature;
use Polygontech\SmsService\Responses\BulkSmsChargeEstimation;
use Polygontech\SmsService\Responses\BulkSmsResponse;
use Polygontech\SmsService\Responses\SingleSmsChargeEstimation;
use Polygontech\SmsService\Responses\SingleSmsResponse;

class Sms
{
    public function __construct(private readonly Service $service)
    {
    }

    /**
     * @param Feature $feature
     * @param array<BDMobile> | BDMobile $recipients
     * @param string $message
     * @return SingleSmsResponse | BulkSmsResponse
     */
    public function shoot(Feature $feature, array | BDMobile $recipients, string $message)
    {
        if (is_array($recipients)) {
            return $this->service->shootBulk(new BulkSms($feature, $message, $recipients));
        } else {
            return $this->service->shoot(new SingleSms($feature, $message, $recipients));
        }
    }

    /**
     * @param Feature $feature
     * @param array<BDMobile> | BDMobile $recipients
     * @param string $message
     * @return SingleSmsChargeEstimation | BulkSmsChargeEstimation
     */
    public function estimateCharge(Feature $feature, array | BDMobile $recipients, string $message)
    {
        if (is_array($recipients)) {
            return $this->service->estimateBulkCharge(new BulkSms($feature, $message, $recipients));
        } else {
            return $this->service->estimateSingleCharge(new SingleSms($feature, $message, $recipients));
        }
    }
}
