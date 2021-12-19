<?php
declare(strict_types=1);

namespace Pich\WayForPay\Gateway\Response;

use Magento\Payment\Gateway\Response\HandlerInterface;
use Pich\WayForPay\Api\ApiFieldsInterface;

class ChargePaymentHandler implements HandlerInterface
{
    private array $additionalInformation = [
        ApiFieldsInterface::CARD_PAN,
        ApiFieldsInterface::CARD_TYPE,
        ApiFieldsInterface::ISSUER_BANK_COUNTRY,
        ApiFieldsInterface::ISSUER_BANK_NAME,
        ApiFieldsInterface::PAYMENT_SYSTEM,
    ];

    public function handle(array $handlingSubject, array $response)
    {
        $payment = $handlingSubject['payment']->getPayment();

        foreach ($this->additionalInformation as $responseKey) {
            if (!empty($response[$responseKey])) {
                $payment->setAdditionalInformation($responseKey, $response[$responseKey]);
            }
        }

        $payment->setTransactionId($response[ApiFieldsInterface::ORDER_REFERENCE]);
        $payment->setIsTransactionClosed(!$response[ApiFieldsInterface::IS_WAITIING_3DS]);
    }
}
