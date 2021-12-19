<?php
declare(strict_types=1);

namespace Pich\WayForPay\Controller\Checkout;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Payment\Model\Method\Logger;
use Magento\Sales\Api\Data\OrderInterfaceFactory;
use Magento\Sales\Api\InvoiceRepositoryInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Model\Order\InvoiceNotifier;

class Service implements HttpGetActionInterface
{
    private Logger $paymentLogger;
    private ResultFactory $resultFactory;
    private OrderRepositoryInterface $orderRepository;
    private InvoiceRepositoryInterface $invoiceRepository;
    private InvoiceNotifier $invoiceNotifier;

    public function __construct(
        Logger $paymentLogger,
        ResultFactory $resultFactory,
        OrderRepositoryInterface $orderRepository,
        InvoiceRepositoryInterface $invoiceRepository,
        InvoiceNotifier $invoiceNotifier,
        OrderInterfaceFactory $orderFactory
    ) {
        $this->paymentLogger = $paymentLogger;
        $this->resultFactory = $resultFactory;
        $this->orderRepository = $orderRepository;
        $this->invoiceRepository = $invoiceRepository;
        $this->invoiceNotifier = $invoiceNotifier;
        $this->orderFactory = $orderFactory;
    }

    public function execute()
    {
        $rawRequestBody = \json_decode((string) file_get_contents('php://input'), true);
        $this->paymentLogger->debug(['response' => $rawRequestBody]);
        $success = false;

        if (! empty($rawRequestBody['orderReference'])) {
            $order = $this->orderFactory->create()->loadByIncrementId($rawRequestBody['orderReference']);

            if ($order->getId()) {
                if ($rawRequestBody['reason'] === 'ok') {
                    $success = true;
                    $invoice = $order->prepareInvoice();
                    $invoice->register();
                    $this->invoiceRepository->save($invoice);
                    $this->invoiceNotifier->notify($invoice);
                } else {
                    $order->cancel();
                    $this->orderRepository->save($order);
                }
            }
        }

        return $this->resultFactory
            ->create(ResultFactory::TYPE_JSON)
            ->setData(['success' => $success]);
    }
}
