<h1 align="center">polygontech/sms-service-client</h1>

<p align="center">
    <strong>Send SMS through sms-service of Polygon Technology</strong>
</p>

polygontech/sms-service-client is mainly used in laravel projects at polygontech in combination of [sms-service(e.g.)](https://github.com/PolygonTechnology-xyz/ranks-reward-sms), which is responsible sending sms as a microservice. So, make sure of installing and running the sms-service before integrating this client.

## Installation

The preferred method of installation is via [Composer](https://getcomposer.org/). Run the following
command to install the package and add it as a requirement to your project's
`composer.json`:

```bash
composer require polygontech/sms-service-client
```

then, publish the needed config:

```bash
php artisan vendor:publish --provider='Polygontech\SmsService\ServiceProvider'

# or,

php artisan vendor:publish # and select 'Polygontech\SmsService\ServiceProvider' when prompted
```

## Usage

First of all, create a `enum` implementing the `interface` named `Feature`. <b>The `enum` should contain cases for <i>features</i> supported by the installed sms service.</b> For example for a <i>sms-service</i> supporting <i>test, otp</i> features, the `enum` should look like:

```php
use Polygontech\SmsService\Inputs\Feature;

enum SmsFeatures implements Feature
{
    case TEST;
    case OTP;

    public function getFeatureType(): string
    {
        switch ($this) {
            case self::TEST: return "test";
            case self::OTP: return "otp";
        }
    }
}

// or,

enum SmsFeatures : string implements Feature
{
    case TEST = "test";
    case OTP = "otp";

    public function getFeatureType(): string
    {
        return $this->value;
    }
}
```

Then, to shoot a single sms:

```php
use Polygontech\CommonHelpers\Mobile\BDMobile;
use Polygontech\SmsService\Facades\Sms;
use Polygontech\SmsService\Responses\SingleSmsResponse;

/** @var SingleSmsResponse $output */
$output = Sms::shoot(SmsFeatures::TEST, new BDMobile("+8801678242960"), "test sms"));
```

To shoot a bulk sms:

```php
use Polygontech\CommonHelpers\Mobile\BDMobile;
use Polygontech\SmsService\Facades\Sms;
use Polygontech\SmsService\Responses\BulkSmsResponse;

/** @var BulkSmsResponse $output */
$output = Sms::shoot(SmsFeatures::TEST, [
    new BDMobile("+8801678242960"),
    new BDMobile("+8801678242961"),
], "test bulk sms"));
```

## Contributing

Contributions are welcome! To contribute, please familiarize yourself with
[CONTRIBUTING.md](CONTRIBUTING.md).

## Copyright and License

The polygontech/nagad-disbursement library is copyright © [Shafiqul Islam](https://github.com/ShafiqIslam/), [Polygon Technology](https://polygontech.xyz/) and
licensed for use under the MIT License (MIT). Please see [LICENSE](LICENSE) for more
information.
