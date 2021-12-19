<?php
declare(strict_types=1);

namespace Pich\WayForPay\Model\Adapter;

use Pich\WayForPay\Api\AdapterInterface;
use Pich\WayForPay\Api\ApiFieldsInterface;
use Pich\WayForPay\Gateway\Config\Config;
use Pich\WayForPay\Model\Sdk\Wizard\PurchaseWizard;
use WayForPay\SDK\Credential\AccountSecretTestCredential;
use WayForPay\SDK\Credential\AccountSecretCredential;
use WayForPay\SDK\Wizard\ChargeWizard;
use WayForPay\SDK\Wizard\RefundWizard;
use WayForPay\SDK\Collection\ProductCollection;
use WayForPay\SDK\Domain\Product;
use WayForPay\SDK\Domain\Card;
use WayForPay\SDK\Domain\Client;
use WayForPay\SDK\Contract\ResponseInterface;

class WayForPay implements AdapterInterface
{
    private Config $paymentConfig;
    private ?AccountSecretCredential $credentials = null;

    public function __construct(Config $paymentConfig)
    {
        $this->paymentConfig = $paymentConfig;
    }

    public function charge(array $data): ResponseInterface
    {
        return ChargeWizard::get($this->getCredentials())
            ->setOrderReference($data[ApiFieldsInterface::ORDER_REFERENCE])
            ->setAmount($data[ApiFieldsInterface::AMOUNT])
            ->setCurrency($data[ApiFieldsInterface::CURRENCY])
            ->setOrderDate($data[ApiFieldsInterface::ORDER_DATE])
            ->setMerchantDomainName($data[ApiFieldsInterface::MERCHANT_DOMAIN_NAME])
            ->setMerchantTransactionSecureType($data[ApiFieldsInterface::MERCHANT_TRANSACTION_SECURE_TYPE])
            ->setClient($this->getClient($data))
            ->setProducts($this->getProducts($data[ApiFieldsInterface::PRODUCTS]))
            ->setCard(new Card(
                $data[ApiFieldsInterface::CARD_NUMBER],
                $data[ApiFieldsInterface::CARD_EXP_MONTH],
                $data[ApiFieldsInterface::CARD_EXP_YEAR],
                $data[ApiFieldsInterface::CARD_CVV],
                $data[ApiFieldsInterface::CARD_HOLDER]
            ))
            ->getRequest()
            ->send();
    }

    public function refund(array $data)
    {
        return RefundWizard::get($this->getCredentials())
            ->setOrderReference($data[ApiFieldsInterface::ORDER_REFERENCE])
            ->setAmount($data[ApiFieldsInterface::AMOUNT])
            ->setCurrency($data[ApiFieldsInterface::CURRENCY])
            ->setComment($data[ApiFieldsInterface::COMMENT])
            ->getRequest()
            ->send();
    }

    public function purchase(array $data)
    {
        return PurchaseWizard::get($this->getCredentials())
            ->setMerchantDomainName($data[ApiFieldsInterface::MERCHANT_DOMAIN_NAME])
            ->setLanguage($data[ApiFieldsInterface::LANGUAGE])
            ->setReturnUrl($data[ApiFieldsInterface::RETURN_URL])
            ->setServiceUrl($data[ApiFieldsInterface::SERVICE_URL])
            ->setOrderReference($data[ApiFieldsInterface::ORDER_REFERENCE])
            ->setOrderDate($data[ApiFieldsInterface::ORDER_DATE])
            ->setAmount($data[ApiFieldsInterface::AMOUNT])
            ->setCurrency($data[ApiFieldsInterface::CURRENCY])
            ->setProducts($this->getProducts($data[ApiFieldsInterface::PRODUCTS]))
            ->setClient($this->getClient($data))
            ->getRequest()
            ->send();
    }

    private function getCredentials()
    {
        if (null === $this->credentials) {
            if ($this->paymentConfig->isSandboxMode()) {
                $this->credentials = new AccountSecretTestCredential();
            } else {
                $this->credentials = new AccountSecretCredential(
                    $this->paymentConfig->getMerchantAcount(),
                    $this->paymentConfig->getMerchantSecretKey()
                );
            }
        }

        return $this->credentials;
    }

    private function getProducts(array $productData): ProductCollection
    {
        $products = [];

        foreach ($productData as $product) {
            $products[] = new Product(
                $product[ApiFieldsInterface::PRODUCT_NAME],
                $product[ApiFieldsInterface::PRODUCT_PRICE],
                $product[ApiFieldsInterface::PRODUCT_COUNT]
            );
        }

        return new ProductCollection($products);
    }

    private function getClient($data): Client
    {
        return new Client(
            $data[ApiFieldsInterface::CLIENT_FIRST_NAME],
            $data[ApiFieldsInterface::CLIENT_LAST_NAME],
            $data[ApiFieldsInterface::CLIENT_EMAIL],
            $data[ApiFieldsInterface::CLIENT_EMAIL],
            $data[ApiFieldsInterface::CLIENT_COUNTRY]
        );
    }
}
