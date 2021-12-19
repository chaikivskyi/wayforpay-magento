<?php
declare(strict_types=1);

namespace Pich\WayForPay\Gateway\Http\Client;

use Pich\WayForPay\Api\ApiFieldsInterface;

class Refund extends AbstractClient
{
    protected function process(array $data)
    {
        $response = $this->adapter->refund($data);
        $reason = $response->getReason();

        return [
            ApiFieldsInterface::TRANSACTION_STATUS => $response->getTransactionStatus(),
            ApiFieldsInterface::ORDER_REFERENCE => $response->getOrderReference(),
            ApiFieldsInterface::IS_PAYMENT_SUCCESS => $reason->isOK(),
            ApiFieldsInterface::RESPONSE_CODE => $reason->getCode(),
            ApiFieldsInterface::IS_WAITIING_3DS => $reason->isWaiting3DS(),
            ApiFieldsInterface::REASON_TEXT => $reason->getMessage(),
        ];
    }
}
