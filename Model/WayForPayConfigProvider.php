<?php
declare(strict_types=1);

namespace Pich\WayForPay\Model;

use Magento\Checkout\Model\ConfigProviderInterface;
use Magento\Framework\UrlInterface;

class WayForPayConfigProvider implements ConfigProviderInterface
{
    private UrlInterface $urlBuilder;

    public function __construct(UrlInterface $urlBuilder)
    {
        $this->urlBuilder = $urlBuilder;
    }

    public function getConfig()
    {
        return ['payment' => [
            'wayforpay' => [
                'redirectUrl' => $this->urlBuilder->getUrl('wayforpay/checkout/start')
            ],
        ]];
    }
}
