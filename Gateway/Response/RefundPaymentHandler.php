<?php
declare(strict_types=1);

namespace Pich\WayForPay\Gateway\Response;

use Magento\Payment\Gateway\Response\HandlerInterface;

class RefundPaymentHandler implements HandlerInterface
{
    public function handle(array $handlingSubject, array $response)
    {
        $payment = $handlingSubject['payment']->getPayment();
        $payment->setIsTransactionClosed(true);
        $payment->setShouldCloseParentTransaction(!(bool)$payment->getCreditmemo()->getInvoice()->canRefund());
    }
}
