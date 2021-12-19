<?php
declare(strict_types=1);

namespace Pich\WayForPay\Controller\Checkout;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NotFoundException;
use Magento\Framework\Message\ManagerInterface;
use Pich\WayForPay\Model\Quote\QuoteManagement;
use Pich\WayForPay\Model\UrlRegistry;

class Start implements HttpGetActionInterface
{
    private QuoteManagement $quoteManagement;
    private UrlRegistry $urlRegistry;
    private ResultFactory $resultFactory;
    private ManagerInterface $messageManager;

    public function __construct(
        QuoteManagement $quoteManagement,
        UrlRegistry $urlRegistry,
        ResultFactory $resultFactory,
        ManagerInterface $messageManager
    ) {
        $this->quoteManagement = $quoteManagement;
        $this->urlRegistry = $urlRegistry;
        $this->resultFactory = $resultFactory;
        $this->messageManager = $messageManager;
    }

    /**
     * Execute action based on request and return result
     *
     * @return ResultInterface|ResponseInterface
     * @throws NotFoundException
     */
    public function execute()
    {
        $result = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        try {
            $this->quoteManagement->placeOrder();
            $url = $this->urlRegistry->get();

            if ($url) {
                return $result->setUrl($url);
            }
        } catch (\Exception $e) {
        }

        $this->messageManager->addErrorMessage('Something went wrong!');
        return $result->setRefererUrl();
    }
}
