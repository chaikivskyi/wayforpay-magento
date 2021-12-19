define([
    'uiComponent',
    'Magento_Checkout/js/model/payment/renderer-list'
], function (Component, rendererList) {
    'use strict';

    rendererList.push(
        {
            type: 'wayforpay_cc',
            component: 'Pich_WayForPay/js/view/payment/method-renderer/wayforpay-cc'
        },
        {
            type: 'wayforpay_sp',
            component: 'Pich_WayForPay/js/view/payment/method-renderer/wayforpay-sp'
        }
    );

    return Component.extend({});
});
