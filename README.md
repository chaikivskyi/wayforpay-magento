# About

This extension provides integration with WayForPay payment system for Magento 2.

# Requirements
Magento 2.3.7+</br>
php 7.4+
# Installation
`composer require pich/wayforpay-magento`</br>
`php bin/magento s:up`
# Feature List
* Sandbox, live mode
* Ability to pay with credit card on store (https://wiki.wayforpay.com/en/view/852194)
* Ability to pay on WayForPay secure page (https://wiki.wayforpay.com/en/view/852102)
* Ability to refund payment in admin panel (https://wiki.wayforpay.com/en/view/852115)
# Sandbox Mode
Enable option `Stores > Configuration > Sales > Payment Method > WayForPay > Sandbox Mode` to have possibility make test payments.</br>
You need to use a real "Visa/MasterCard" card for test payments. All test payments will be auto refunded throw 15 minutes after payment is done.
