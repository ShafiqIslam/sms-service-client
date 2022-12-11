<?php

namespace Polygontech\SmsService\Responses;

use Polygontech\CommonHelpers\Money\BDT;

class BulkSmsChargeEstimation
{
    public readonly SingleSmsChargeEstimation $singleSmsCharge;
    public readonly int $numberCount;
    public readonly BDT $totalCharge;

    public function __construct($response)
    {
        $this->singleSmsCharge = new SingleSmsChargeEstimation($response['single_sms_charge']);
        $this->totalCharge = BDT::fromDecimal($response['total_charge']);
        $this->numberCount = intval($response['number_count']);
    }
}
