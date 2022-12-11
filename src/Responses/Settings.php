<?php

namespace Polygontech\SmsService\Responses;


class Settings
{
    /** @var array<SingleSetting> */
    public readonly array $settings;

    public function __construct($res)
    {
        $settings = [];

        foreach ($res as $item) {
            $settings[] = new SingleSetting($item);
        }

        $this->settings = $settings;
    }

    public function toArray()
    {
        $result = [];
        foreach ($this->settings as $setting) {
            $result[] = $setting->toArray();
        }
        return $result;
    }
}
