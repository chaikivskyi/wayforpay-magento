<?php
declare(strict_types=1);

namespace Pich\WayForPay\Model\Quote;

use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Customer\Model\Session;
use Magento\Quote\Model\GuestCart\GuestCartManagement;
use Magento\Quote\Model\QuoteManagement as CartManagement;

class QuoteManagement
{
    private Session $customerSession;
    private GuestCartManagement $guestCartManagement;
    private CartManagement $cartManagement;
    private CheckoutSession $checkoutSession;

    public function __construct(
        Session $customerSession,
        GuestCartManagement $guestCartManagement,
        CartManagement $cartManagement,
        CheckoutSession $checkoutSession
    ) {
        $this->customerSession = $customerSession;
        $this->guestCartManagement = $guestCartManagement;
        $this->cartManagement = $cartManagement;
        $this->checkoutSession = $checkoutSession;
    }

    public function placeOrder()
    {
        $quoteId = $this->checkoutSession->getQuoteId();
        return $this->customerSession->isLoggedIn()
            ? $this->cartManagement->placeOrder($quoteId)
            : $this->guestCartManagement->placeOrder($quoteId);
    }
}
