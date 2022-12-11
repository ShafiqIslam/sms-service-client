<?php

namespace Polygontech\SmsService\Inputs;

use Polygontech\CommonHelpers\Mobile\BDMobile;

class BulkSms extends ASms
{
    /**
     * @param Feature $feature
     * @param string $message
     * @param array<BDMobile> $receipients
     */
    public function __construct(
        Feature $feature,
        string $message,
        public readonly array $receipients,
    ) {
        parent::__construct($feature, $message);
    }

    /**
     * @return array<string>
     */
    private function getReceipientsAsStringArray(): array
    {
        return array_map(fn (BDMobile $mobile) => $mobile->getWithCountryCode(), $this->receipients);
    }

    protected function toArrayExtensions(): array
    {
        return [
            "mobiles" => $this->getReceipientsAsStringArray(),
        ];
    }
}
