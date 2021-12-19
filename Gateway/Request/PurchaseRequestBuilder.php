<?php
declare(strict_types=1);

namespace Pich\WayForPay\Gateway\Request;

use Magento\Framework\UrlInterface;
use Magento\Payment\Gateway\Request\BuilderInterface;
use Pich\WayForPay\Api\ApiFieldsInterface;

class PurchaseRequestBuilder implements BuilderInterface
{
    private UrlInterface $url;

    public function __construct(UrlInterface $url)
    {
        $this->url = $url;
    }

    public function build(array $buildSubject)
    {
        return [
            ApiFieldsInterface::SERVICE_URL => $this->url->getUrl('wayforpay/checkout/service'),
            ApiFieldsInterface::RETURN_URL => $this->url->getUrl('checkout/onepage/success'),
            ApiFieldsInterface::LANGUAGE => 'UA',
        ];
    }
}
