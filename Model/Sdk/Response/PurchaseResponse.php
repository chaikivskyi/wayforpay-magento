<?php
declare(strict_types=1);

namespace Pich\WayForPay\Model\Sdk\Response;

use Pich\WayForPay\Model\Sdk\Domain\Checkout;
use WayForPay\SDK\Contract\ResponseInterface;
use WayForPay\SDK\Domain\Reason;

class PurchaseResponse implements ResponseInterface
{
    private $checkout;
    private $reason;

    public function __construct(array $data)
    {
        $this->checkout = Checkout::fromArray($data);
        $this->reason = new Reason(1, '');
    }

    public function getCheckout()
    {
        return $this->checkout;
    }

    public function getReason()
    {
        return $this->reason;
    }
}
