<?php

namespace Polygontech\SmsService\Inputs;

use Polygontech\CommonHelpers\Mobile\BDMobile;

class SingleSms extends ASms
{
    /**
     * @param Feature $feature
     * @param string $message
     * @param BDMobile $receipient
     */
    public function __construct(
        Feature $feature,
        string $message,
        public readonly BDMobile $receipient,
    ) {
        parent::__construct($feature, $message);
    }

    protected function toArrayExtensions(): array
    {
        return [
            "mobile" => $this->receipient->getWithCountryCode(),
        ];
    }
}
