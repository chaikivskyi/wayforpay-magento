<?php
declare(strict_types=1);

namespace Pich\WayForPay\Gateway\Http\Client;

use Pich\WayForPay\Api\ApiFieldsInterface;

class Charge extends AbstractClient
{
    protected function process(array $data)
    {
        $response = $this->adapter->charge($data);
        $transaction = $response->getTransaction();
        $reason = $response->getReason();
        return [
            ApiFieldsInterface::ORDER_REFERENCE => $transaction->getOrderReference(),
            ApiFieldsInterface::CREATED_DATE => $transaction->getCreatedDate()->format(\DateTimeInterface::RFC2822),
            ApiFieldsInterface::AMOUNT => $transaction->getAmount(),
            ApiFieldsInterface::CURRENCY => $transaction->getCurrency(),
            ApiFieldsInterface::TRANSACTION_STATUS => $transaction->getStatus(),
            ApiFieldsInterface::PROCESSING_DATE => $transaction->getProcessingDate()->format(\DateTimeInterface::RFC2822),
            ApiFieldsInterface::EMAIL => $transaction->getEmail(),
            ApiFieldsInterface::PHONE => $transaction->getPhone(),
            ApiFieldsInterface::PAYMENT_SYSTEM => $transaction->getPaymentSystem(),
            ApiFieldsInterface::CARD_PAN => $transaction->getCardPan(),
            ApiFieldsInterface::CARD_TYPE => $transaction->getCardType(),
            ApiFieldsInterface::ISSUER_BANK_COUNTRY => $transaction->getIssuerBankCountry(),
            ApiFieldsInterface::ISSUER_BANK_NAME => $transaction->getIssuerBankName(),
            ApiFieldsInterface::FEE => $transaction->getFee(),
            ApiFieldsInterface::BASE_AMOUNT => $transaction->getBaseAmount(),
            ApiFieldsInterface::BASE_CURRENCY => $transaction->getBaseCurrency(),
            ApiFieldsInterface::AUTH_CODE => $transaction->getAuthCode(),
            ApiFieldsInterface::AUTH_TICKET => $transaction->getAuthTicket(),
            ApiFieldsInterface::REC_TOKEN => $transaction->getRecToken() ? $transaction->getRecToken()->getToken() : '',
            ApiFieldsInterface::D3_ACS_URL => $transaction->getD3AcsUrl(),
            ApiFieldsInterface::D3_MD => $transaction->getD3Md(),
            ApiFieldsInterface::D3_PAREQ => $transaction->getD3Pareq(),
            ApiFieldsInterface::RETURN_URL => $transaction->getReturnUrl(),
            ApiFieldsInterface::IS_PAYMENT_SUCCESS => $reason->isOK(),
            ApiFieldsInterface::RESPONSE_CODE => $reason->getCode(),
            ApiFieldsInterface::IS_WAITIING_3DS => $reason->isWaiting3DS(),
            ApiFieldsInterface::REASON_TEXT => $reason->getMessage(),
        ];
    }
}
