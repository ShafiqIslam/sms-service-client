<?php

namespace Polygontech\SmsService\Responses;

use Polygontech\CommonHelpers\Mobile\BDMobile;
use Polygontech\CommonHelpers\Money\BDT;

class SingleSmsResponse
{
    public readonly BDMobile $mobile;
    public readonly SmsStatus $status;
    public readonly BDT $chargePerSms;
    public readonly BDT $charge;
    public readonly string $smsId;
    public readonly int $smsCount;

    public function __construct($response)
    {
        $this->mobile = new BDMobile($response['mobile']);
        $this->status = SmsStatus::tryFrom($response['status']);
        $this->charge = BDT::fromDecimal($response['charge']);
        $this->chargePerSms = BDT::fromDecimal($response['charge_per_sms']);
        $this->smsId = $response['sms_id'];
        $this->smsCount = intval($response['sms_count']);
    }

    public function isSuccessful(): bool
    {
        return $this->status == SmsStatus::SUCCESSFUL;
    }

    public function isFailed(): bool
    {
        return $this->status == SmsStatus::FAILED;
    }

    public function isPending(): bool
    {
        return $this->status == SmsStatus::PENDING;
    }
}
