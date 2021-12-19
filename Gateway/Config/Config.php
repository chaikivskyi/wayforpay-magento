<?php
declare(strict_types=1);

namespace Pich\WayForPay\Gateway\Config;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Encryption\EncryptorInterface;
use Magento\Payment\Gateway\Config\Config as BasePaymentConfig;

class Config extends BasePaymentConfig
{
    private EncryptorInterface $encryptor;

    public function __construct(
        ScopeConfigInterface $scopeConfig,
        EncryptorInterface $encryptor,
        $methodCode = null,
        $pathPattern = BasePaymentConfig::DEFAULT_PATH_PATTERN
    ) {
        parent::__construct($scopeConfig, $methodCode, $pathPattern);
        $this->encryptor = $encryptor;
    }

    public function isSandboxMode(): bool
    {
        return (bool) $this->getValue('sandbox_mode');
    }

    public function getMerchantAcount(): string
    {
        return (string) $this->getValue('merchant_account');
    }

    public function getMerchantSecretKey(): string
    {
        return $this->encryptor->decrypt($this->getValue('merchant_secret_key'));
    }
}
