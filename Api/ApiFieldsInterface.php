<?php

namespace Pich\WayForPay\Api;

interface ApiFieldsInterface
{
    const ORDER_REFERENCE = 'orderReference';
    const ORDER_DATE = 'orderDate';
    const CARD_PAN = 'cardPan';
    const CARD_TYPE = 'cardType';
    const ISSUER_BANK_COUNTRY = 'issuerBankCountry';
    const ISSUER_BANK_NAME = 'issuerBankName';
    const PAYMENT_SYSTEM = 'paymentSystem';
    const IS_PAYMENT_SUCCESS = 'isOk';
    const REASON_TEXT = 'reasonText';
    const IS_WAITIING_3DS = 'isWaiting3DS';
    const TRANSACTION_STATUS = 'transactionStatus';
    const RESPONSE_CODE = 'responseCode';
    const CREATED_DATE = 'createdDate';
    const AMOUNT = 'amount';
    const CURRENCY = 'currency';
    const PROCESSING_DATE = 'processingDate';
    const EMAIL = 'email';
    const PHONE = 'phone';
    const FEE = 'fee';
    const BASE_AMOUNT = 'baseAmount';
    const BASE_CURRENCY = 'baseCurrency';
    const AUTH_CODE = 'authCode';
    const AUTH_TICKET = 'authTicket';
    const REC_TOKEN = 'recTocken';
    const D3_ACS_URL = 'd3AcsUrl';
    const D3_MD = 'd3Md';
    const D3_PAREQ = 'd3Pareq';
    const RETURN_URL = 'returnUrl';
    const COMMENT = 'comment';
    const MERCHANT_TRANSACTION_SECURE_TYPE = 'merchantTransactionSecureTtype';
    const CLIENT_FIRST_NAME = 'clientFirstName';
    const CLIENT_LAST_NAME = 'clientLastName';
    const CLIENT_EMAIL = 'clientEmail';
    const CLIENT_PHONE = 'clientPhone';
    const CLIENT_COUNTRY = 'clientCountry';
    const PRODUCTS = 'products';
    const PRODUCT_NAME = 'productName';
    const PRODUCT_PRICE = 'productPrice';
    const PRODUCT_COUNT = 'productCount';
    const CARD_NUMBER = 'card';
    const CARD_EXP_MONTH = 'expMonth';
    const CARD_EXP_YEAR = 'expYear';
    const CARD_CVV = 'cardCvv';
    const CARD_HOLDER = 'cardHolder';
    const MERCHANT_DOMAIN_NAME = 'merchantDomainName';
    const LANGUAGE = 'language';
    const SERVICE_URL = 'serviceUrl';
    const CHECKOUT_URL = 'url';
}
