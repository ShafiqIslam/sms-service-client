<?php

namespace Polygontech\SmsService\Responses;


class Gateways
{
    /** @var string[] */
    public readonly array $names;

    public function __construct($res)
    {
        $this->names = $res;
    }

    public function combine(): array
    {
        return array_combine($this->names, $this->names);
    }
}
