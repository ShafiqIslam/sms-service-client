<?php

namespace Polygontech\SmsService\Responses;

use Polygontech\CommonHelpers\Money\BDT;

class SingleSetting
{
    public readonly int $id;
    public readonly string $feature;
    public readonly string $gateway;
    public readonly BDT $chargePerSms;

    public function __construct($res)
    {
        $this->id = intval($res['id']);
        $this->feature = $res['feature'];
        $this->gateway = $res['gateway'];
        $this->chargePerSms = BDT::fromDecimal($res['charge_per_sms']);
    }

    public function toArray()
    {
        return [
            "id" => $this->id,
            "feature" => $this->feature,
            "gateway" => $this->gateway,
            "charge_per_sms" => $this->chargePerSms->toDecimal()
        ];
    }
}
