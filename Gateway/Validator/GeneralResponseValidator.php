<?php
declare(strict_types=1);

namespace Pich\WayForPay\Gateway\Validator;

use Magento\Payment\Gateway\Validator\AbstractValidator;
use Pich\WayForPay\Api\ApiFieldsInterface;

class GeneralResponseValidator extends AbstractValidator
{
    public function validate(array $validationSubject)
    {
        $response = $validationSubject['response'];
        $isValid = true;
        $errorMessages = [];

        if (isset($response[ApiFieldsInterface::IS_PAYMENT_SUCCESS])
            && $response[ApiFieldsInterface::IS_PAYMENT_SUCCESS] !== true
        ) {
            $isValid = false;
            $errorMessages[] = $response[ApiFieldsInterface::REASON_TEXT];
        }

        return $this->createResult($isValid, $errorMessages);
    }
}
