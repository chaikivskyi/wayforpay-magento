<?php
declare(strict_types=1);

namespace Pich\WayForPay\Gateway\Validator;

use Magento\Payment\Gateway\Validator\AbstractValidator;
use Pich\WayForPay\Api\ApiFieldsInterface;

class UrlResponseValidator extends AbstractValidator
{

    public function validate(array $validationSubject)
    {
        $response = $validationSubject['response'];
        $isValid = true;
        $errorMessages = [];

        if (empty($response[ApiFieldsInterface::CHECKOUT_URL])) {
            $isValid = false;
            $errorMessages[] = __('Something went wront');
        }

        return $this->createResult($isValid, $errorMessages);
    }
}
