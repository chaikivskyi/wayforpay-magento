<?php
declare(strict_types=1);

namespace Pich\WayForPay\Model\Sdk\Wizard;

use Pich\WayForPay\Model\Sdk\Request\PurchaseRequest;
use WayForPay\SDK\Credential\AccountSecretCredential;

class PurchaseWizard extends \WayForPay\SDK\Wizard\PurchaseWizard
{
    public static function get(AccountSecretCredential $credential)
    {
        return new self($credential);
    }

    public function getRequest()
    {
        $this->check();

        return new PurchaseRequest(
            $this->credential,
            $this->orderReference,
            $this->amount,
            $this->currency,
            $this->products,
            $this->orderDate,
            $this->merchantDomainName,
            $this->merchantTransactionType,
            $this->merchantTransactionSecureType,
            $this->client,
            $this->serviceUrl,
            $this->returnUrl,
            $this->language,
            $this->holdTimeout,
            $this->merchantAuthType,
            $this->socialUri
        );
    }
}
