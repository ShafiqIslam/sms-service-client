<?php

namespace Polygontech\SmsService\Responses;

use Polygontech\CommonHelpers\Enum\ReverseEnum;

enum SmsStatus: string
{
    use ReverseEnum;

    case SUCCESSFUL = "Successful";
    case FAILED = "Failed";
    case PENDING = "Pending";
    case UNKNOWN = "Unknown";
}
