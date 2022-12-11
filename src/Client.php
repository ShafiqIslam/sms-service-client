<?php

namespace Polygontech\SmsService;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\RequestException;
use Polygontech\SmsService\Exceptions\SmsServiceNotWorking;
use Polygontech\SmsService\Exceptions\ValidationError;
use Psr\Http\Message\ResponseInterface;

/**
 * @internal
 */
class Client
{
    public function __construct(private readonly HttpClient $httpClient, private readonly Config $config)
    {
    }

    public function get($uri)
    {
        return $this->call("get", $uri);
    }

    private function decodeResponse(ResponseInterface $response, $assoc = true)
    {
        $string = $response->getBody()->getContents();
        $result = json_decode($string, $assoc);
        if (json_last_error() != JSON_ERROR_NONE && $string != "") {
            $result = $string;
        }
        return $result;
    }

    /**
     * @param $method
     * @param $uri
     * @param null $data
     * @return array
     * @throws SmsServiceNotWorking
     * @throws ValidationError
     */
    private function call($method, $uri, $data = null)
    {
        try {
            $res = $this->httpClient->request(strtoupper($method), $this->config->makeUrl($uri), $this->getOptions($data));
            return $this->decodeResponse($res);
        } catch (RequestException $e) {
            if (!$e->hasResponse()) throw new SmsServiceNotWorking($e->getMessage());

            $error = $e->getResponse();
            $res = $this->decodeResponse($error);
            $status = $error->getStatusCode();

            if (!$res) throw new SmsServiceNotWorking($error->getReasonPhrase(), $status);

            if ($status >= 400 && $status < 500) {
                if (array_key_exists("title", $res)) {
                    throw new ValidationError($res['title'] . ": " . json_encode($res['errors']), $status);
                } else {
                    throw new ValidationError($res['message'], $status);
                }
            }

            throw new SmsServiceNotWorking($res['message'], $status);
        }
    }

    /**
     * @param null $data
     * @return array
     */
    private function getOptions($data = null)
    {
        $options['headers'] = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'x-api-key' => $this->config->apiKey
        ];
        if ($data) {
            $options['json'] = $data;
        }
        return $options;
    }

    public function post($uri, $data)
    {
        return $this->call("post", $uri, $data);
    }
}
