<?php

namespace Polygontech\SmsService;

use Polygontech\CommonHelpers\Mobile\BDMobile;
use Polygontech\SmsService\Exceptions\ValidationError;
use Polygontech\SmsService\Inputs\BulkSms;
use Polygontech\SmsService\Inputs\SingleSms;
use Polygontech\SmsService\Responses\SingleSmsChargeEstimation;
use Polygontech\SmsService\Responses\SingleSmsResponse;
use Polygontech\SmsService\Responses\BulkSmsChargeEstimation;
use Polygontech\SmsService\Responses\BulkSmsResponse;
use Polygontech\SmsService\Responses\Gateways;
use Polygontech\SmsService\Responses\Settings;

/**
 * @internal
 */
class Service
{
    public function __construct(private readonly Client $client)
    {
    }

    /**
     * @param SingleSms $sms
     * @return SingleSmsChargeEstimation
     */
    public function estimateSingleCharge(SingleSms $sms)
    {
        $res = $this->client->post('/api/sms/single/estimate-charge', $sms->toArray());
        return new SingleSmsChargeEstimation($res);
    }

    /**
     * @param SingleSms $sms
     * @return SingleSmsResponse
     */
    public function shoot(SingleSms $sms)
    {
        $res = $this->client->post('/api/sms/single', $sms->toArray());
        return new SingleSmsResponse($res);
    }

    /**
     * @param BulkSms $sms
     * @return BulkSmsChargeEstimation
     */
    public function estimateBulkCharge(BulkSms $sms)
    {
        $res = $this->client->post('/api/sms/bulk/estimate-charge', $sms->toArray());
        return new BulkSmsChargeEstimation($res);
    }

    /**
     * @param BulkSms $sms
     * @return BulkSmsResponse
     */
    public function shootBulk(BulkSms $sms)
    {
        $res = $this->client->post('/api/sms/bulk', $sms->toArray());
        return new BulkSmsResponse($res);
    }

    /**
     * @param $message_id
     * @return SingleSmsResponse
     */
    public function getStatus($message_id)
    {
        $res = $this->client->get("/api/sms/single/$message_id/status");
        return new SingleSmsResponse($res);
    }

    /**
     * @return Gateways
     */
    public function getGateways()
    {
        $res = $this->client->get("/api/settings/gateways");
        return new Gateways($res);
    }

    /**
     * @return Settings
     */
    public function getSettings()
    {
        $res = $this->client->get("/api/settings");
        return new Settings($res);
    }

    /**
     * @param $settings_id
     * @param $gateway
     * @param $charge
     * @param $created_by
     * @return null | string
     */
    public function updateSettings($settings_id, $gateway, $charge, $created_by)
    {
        try {
            $this->client->post("/api/settings/$settings_id", [
                "gateway" => $gateway,
                "charge_per_sms" => "" . $charge,
                "requester_name" => $created_by
            ]);
        } catch (ValidationError $e) {
            return $e->getMessage();
        }
    }

    /**
     * @param Feature $feature
     * @param BDMobile $mobile
     * @return array
     */
    public function getStatusesBy(Feature $feature, BDMobile $mobile): array
    {
        $uri = "/api/sms/check-status";
        $uri .= "?mobile={$mobile->getWithCountryCode()}";
        $uri .= "&feature_type={$feature->getFeatureType()}";
        $uri .= "&limit=5";
        return $this->client->get($uri);
    }
}
