<?php
declare(strict_types=1);

namespace Pich\WayForPay\Gateway\Request;

use Magento\Payment\Gateway\Request\BuilderInterface;
use Pich\WayForPay\Api\ApiFieldsInterface;

class RefundRequestBuilder implements BuilderInterface
{
    const DEFAULT_COMMENT = 'Refund on Magento side';

    public function build(array $buildSubject)
    {
        $payment = $buildSubject['payment']->getPayment();
        /** @var \Magento\Sales\Api\Data\CreditmemoInterface $creditMemo */
        $creditMemo = $payment->getCreditmemo();

        return [
            ApiFieldsInterface::ORDER_REFERENCE => $payment->getRefundTransactionId(),
            ApiFieldsInterface::AMOUNT => $creditMemo->getGrandTotal(),
            ApiFieldsInterface::CURRENCY => $creditMemo->getOrderCurrencyCode(),
            ApiFieldsInterface::COMMENT => $creditMemo->getCustomerNote() ?: __(self::DEFAULT_COMMENT),
        ];
    }
}
