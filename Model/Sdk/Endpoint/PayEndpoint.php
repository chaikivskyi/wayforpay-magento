<?php
declare(strict_types=1);

namespace Pich\WayForPay\Model\Sdk\Endpoint;

use WayForPay\SDK\Contract\EndpointInterface;

class PayEndpoint implements EndpointInterface
{
    public function getUrl()
    {
        return 'https://secure.wayforpay.com/pay?behavior=offline';
    }

    public function getMethod()
    {
        return 'POST';
    }
}
