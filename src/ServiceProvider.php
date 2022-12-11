<?php

namespace Polygontech\SmsService;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;
use Polygontech\CommonHelpers\HTTP\URL;
use GuzzleHttp\Client as HttpClient;

/**
 * @internal
 */
class ServiceProvider extends BaseServiceProvider implements DeferrableProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/config.php' => config_path('sms_service.php'),
        ]);

        $this->app->singleton(Sms::class, function ($app) {
            $config = $app['config']['sms_service'];
            $client = new Client($app->make(HttpClient::class), new Config(
                baseUrl: URL::parse($config['base_url']),
                apiKey: $config['api_key'],
            ));
            return new Sms(new Service($client));
        });

        $this->app->bind("sms.service", function ($app) {
            return $app->make(Sms::class);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [Sms::class, "sms.service"];
    }
}
