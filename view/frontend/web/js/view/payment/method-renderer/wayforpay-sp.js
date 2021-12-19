define([
    'jquery',
    'Magento_Checkout/js/view/payment/default',
    'Magento_Checkout/js/action/set-payment-information',
    'Magento_Checkout/js/model/payment/additional-validators',
    'Magento_Checkout/js/model/quote',
    'Magento_Customer/js/customer-data'
], function ($, Component, setPaymentMethodAction, additionalValidators, quote, customerData) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'Pich_WayForPay/payment/wayforpay-sp'
        },

        /** Redirect to wayforpay */
        continueToWayforpay: function () {
            if (additionalValidators.validate()) {
                //update payment method information if additional data was changed
                this.selectPaymentMethod();
                setPaymentMethodAction(this.messageContainer, quote.paymentMethod()).done(
                    function () {
                        customerData.invalidate(['cart']);
                        $.mage.redirect(
                            window.checkoutConfig.payment.wayforpay.redirectUrl
                        );
                    }
                );

                return false;
            }
        }
    });
});
