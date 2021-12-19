<?php
declare(strict_types=1);

namespace Pich\WayForPay\Gateway\Http\Client;

use Pich\WayForPay\Api\ApiFieldsInterface;

class Purchase extends AbstractClient
{
    protected function process(array $data)
    {
        $response = $this->adapter->purchase($data);
        $checkout = $response->getCheckout();

        return [ApiFieldsInterface::CHECKOUT_URL => $checkout->getUrl()];
    }
}
