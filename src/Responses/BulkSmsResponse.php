<?php

namespace Polygontech\SmsService\Responses;

use Polygontech\CommonHelpers\Money\BDT;

class BulkSmsResponse
{
    public readonly string $smsId;
    public readonly SmsStatus $status;
    public readonly BDT $chargePerSms;
    public readonly BDT $totalCharge;
    /** @var array<SingleSmsResponse> */
    public readonly array $singlesResponse;

    public function __construct($response)
    {
        $this->status = SmsStatus::tryFrom($response['bulk_status']);
        $this->chargePerSms = BDT::fromDecimal($response['charge_per_sms']);
        $this->totalCharge = BDT::fromDecimal($response['total_charge']);
        $this->smsId = $response['bulk_id'];

        $singlesResponse = [];
        foreach ($response['individuals'] as $individual) {
            $singlesResponse[] = new SingleSmsResponse($individual);
        }

        $this->singlesResponse = $singlesResponse;
    }
}
