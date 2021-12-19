<?php
declare(strict_types=1);

namespace Pich\WayForPay\Observer;

use Magento\Framework\Event\Observer;
use Magento\Payment\Observer\AbstractDataAssignObserver;

class WayForPayAddCcData extends AbstractDataAssignObserver
{
    private array $ccKeys = [
        'cc_exp_year',
        'cc_exp_month',
        'cc_number',
        'cc_cid',
        'cc_owner',
    ];

    public function execute(Observer $observer)
    {
        $data = $this->readDataArgument($observer);
        $paymentModel = $this->readPaymentModelArgument($observer);

        foreach ($this->ccKeys as $ccKey) {
            $paymentModel->setData($ccKey, $data->getData('additional_data', $ccKey));
        }
    }
}
