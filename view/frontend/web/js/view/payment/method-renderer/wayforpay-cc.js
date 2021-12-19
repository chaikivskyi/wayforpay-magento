define([
    'jquery',
    'Magento_Payment/js/view/payment/cc-form'
], function ($, Component) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'Pich_WayForPay/payment/wayforpay-cc',
            code: 'wayforpay_cc'
        },

        getCode: function () {
            return this.code;
        },

        isActive: function () {
            return this.getCode() === this.isChecked();
        }
    });
});
