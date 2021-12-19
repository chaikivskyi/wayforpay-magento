<?php
declare(strict_types=1);

namespace Pich\WayForPay\Gateway\Validator;

use Magento\Payment\Gateway\Validator\AbstractValidator;
use Magento\Payment\Gateway\ConfigInterface;
use Magento\Payment\Gateway\Validator\ResultInterfaceFactory;

class CurrencyValidator extends AbstractValidator
{
    /**
     * @var ConfigInterface
     */
    private ConfigInterface $paymentConfig;

    public function __construct(
        ResultInterfaceFactory $resultFactory,
        ConfigInterface $paymentConfig
    ) {
        parent::__construct($resultFactory);
        $this->paymentConfig = $paymentConfig;
    }

    public function validate(array $validationSubject)
    {
        $isValid = true;
        $storeId = $validationSubject['storeId'];
        $availableCountries = explode(
            ',',
            $this->paymentConfig->getValue('allowed_currencies', $storeId)
        );

        if (!in_array($validationSubject['currency'], $availableCountries)) {
            $isValid =  false;
        }

        return $this->createResult($isValid);
    }
}
