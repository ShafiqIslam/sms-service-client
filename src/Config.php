<?php

namespace Polygontech\SMSService;

use Polygontech\CommonHelpers\HTTP\URL;

/**
 * @internal
 */
class Config
{
    public function __construct(
        public readonly URL $baseUrl,
        public readonly string $apiKey,
    ) {
    }

    public function makeUrl(string $uri)
    {
        return $this->baseUrl->mutatePath($uri)->getFull();
    }
}
