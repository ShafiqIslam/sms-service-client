<?php

namespace Polygontech\SmsService\Inputs;

/**
 * @internal
 */
abstract class ASms
{
    /**
     * @param Feature $feature
     * @param string $message
     */
    public function __construct(
        public readonly Feature $feature,
        public readonly string $message
    ) {
    }

    public function toArray(): array
    {
        return array_merge([
            "feature" => $this->feature->getFeatureType(),
            "message" => $this->message
        ], $this->toArrayExtensions());
    }

    abstract protected function toArrayExtensions(): array;
}
