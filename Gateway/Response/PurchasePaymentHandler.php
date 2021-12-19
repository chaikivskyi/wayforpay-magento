<?php
declare(strict_types=1);

namespace Pich\WayForPay\Gateway\Response;

use Magento\Payment\Gateway\Response\HandlerInterface;
use Pich\WayForPay\Api\ApiFieldsInterface;
use Pich\WayForPay\Model\UrlRegistry;

class PurchasePaymentHandler implements HandlerInterface
{
    private UrlRegistry $urlRegistry;

    public function __construct(UrlRegistry $urlRegistry)
    {
        $this->urlRegistry = $urlRegistry;
    }

    public function handle(array $handlingSubject, array $response)
    {
        if (isset($response[ApiFieldsInterface::CHECKOUT_URL])) {
            $this->urlRegistry->set($response[ApiFieldsInterface::CHECKOUT_URL]);
        }
    }
}
