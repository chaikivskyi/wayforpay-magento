<?php
declare(strict_types=1);

namespace Pich\WayForPay\Gateway\Request;

use Magento\Payment\Gateway\Request\BuilderInterface;
use Magento\Store\Model\StoreManagerInterface;
use Pich\WayForPay\Api\ApiFieldsInterface;

class ChargeRequestBuilder implements BuilderInterface
{
    private StoreManagerInterface $storeManager;

    public function __construct(StoreManagerInterface $storeManager)
    {
        $this->storeManager = $storeManager;
    }

    public function build(array $buildSubject)
    {
        /** @var \Magento\Payment\Gateway\Data\OrderAdapterInterface $order */
        $order = $buildSubject['payment']->getOrder();
        $billingAddress = $order->getBillingAddress();
        $payment = $buildSubject['payment']->getPayment();

        $result = [
            ApiFieldsInterface::CURRENCY => $order->getCurrencyCode(),
            ApiFieldsInterface::AMOUNT => $buildSubject['amount'],
            ApiFieldsInterface::ORDER_REFERENCE => $order->getOrderIncrementId(),
            ApiFieldsInterface::ORDER_DATE => new \DateTime(),
            ApiFieldsInterface::MERCHANT_TRANSACTION_SECURE_TYPE => 'NON3DS',
            ApiFieldsInterface::MERCHANT_DOMAIN_NAME => $this->storeManager->getStore()->getBaseUrl(),
            ApiFieldsInterface::CLIENT_FIRST_NAME => $billingAddress->getFirstname(),
            ApiFieldsInterface::CLIENT_LAST_NAME => $billingAddress->getLastname(),
            ApiFieldsInterface::CLIENT_EMAIL => $billingAddress->getEmail(),
            ApiFieldsInterface::CLIENT_PHONE => $billingAddress->getTelephone(),
            ApiFieldsInterface::CLIENT_COUNTRY => $billingAddress->getCountryId(),
            ApiFieldsInterface::CARD_NUMBER => $payment->getData('cc_number'),
            ApiFieldsInterface::CARD_EXP_YEAR => $payment->getData('cc_exp_year'),
            ApiFieldsInterface::CARD_EXP_MONTH => $payment->getData('cc_exp_month'),
            ApiFieldsInterface::CARD_CVV => $payment->getData('cc_cid'),
            ApiFieldsInterface::CARD_HOLDER => $payment->getData('cc_owner') ?: sprintf(
                '%s %s',
                $billingAddress->getFirstname(),
                $billingAddress->getLastname()
            ),
            ApiFieldsInterface::PRODUCTS => [],
        ];

        foreach ($order->getItems() as $item) {
            $result['products'][] = [
                ApiFieldsInterface::PRODUCT_NAME => $item->getName(),
                ApiFieldsInterface::PRODUCT_PRICE => $item->getPrice(),
                ApiFieldsInterface::PRODUCT_COUNT => $item->getQtyOrdered(),
            ];
        }

        return $result;
    }
}
