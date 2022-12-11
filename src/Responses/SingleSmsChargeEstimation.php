<?php

namespace Polygontech\SmsService\Responses;

use Polygontech\CommonHelpers\Money\BDT;

class SingleSmsChargeEstimation
{
    public readonly BDT $chargePerSms;
    public readonly int $smsCount;
    public readonly BDT $totalCharge;

    public function __construct($response)
    {
        $this->chargePerSms = BDT::fromDecimal($response['charge_per_sms']);
        $this->totalCharge = BDT::fromDecimal($response['total_charge']);
        $this->smsCount = intval($response['sms_count']);
    }
}
