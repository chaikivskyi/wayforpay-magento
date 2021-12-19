<?php
declare(strict_types=1);

namespace Pich\WayForPay\Model\Sdk\Request;

use Pich\WayForPay\Model\Sdk\Endpoint\PayEndpoint;
use Pich\WayForPay\Model\Sdk\Response\PurchaseResponse;
use WayForPay\SDK\Collection\ProductCollection;
use WayForPay\SDK\Credential\AccountSecretCredential;
use WayForPay\SDK\Domain\Client;
use WayForPay\SDK\Domain\MerchantTypes;
use WayForPay\SDK\Helper\SignatureHelper;
use WayForPay\SDK\Request\ApiRequest;

class PurchaseRequest extends ApiRequest
{
    private $merchantAuthTypeAllowed = [
        MerchantTypes::AUTH_SIMPLE_SIGNATURE
    ];

    private $merchantTransactionSecureTypeAllowed = [
        MerchantTypes::TRANSACTION_SECURE_AUTO,
        MerchantTypes::TRANSACTION_SECURE_3DS,
        MerchantTypes::TRANSACTION_SECURE_NON3DS,
    ];

    private $merchantTransactionTypeAllowed = [
        MerchantTypes::TRANSACTION_AUTO,
        MerchantTypes::TRANSACTION_SALE,
        MerchantTypes::TRANSACTION_AUTH,
    ];

    private string $merchantAuthType;
    private string $merchantDomainName;
    private string $merchantTransactionType;
    private string $merchantTransactionSecureType;
    private string $serviceUrl;
    private string $orderReference;
    private \DateTime $orderDate;
    private float $amount;
    private string $currency;
    private int $holdTimeout;
    private ProductCollection $products;
    private Client $client;
    private string $socialUri;
    private ?string $returnUrl;
    private string $language;

    public function __construct(
        AccountSecretCredential $credential,
        $orderReference,
        $amount,
        $currency,
        ProductCollection $products,
        \DateTime $orderDate,
        $merchantDomainName,
        $merchantTransactionType = null,
        $merchantTransactionSecureType = null,
        Client $client = null,
        $serviceUrl = null,
        ?string $returnUrl = null,
        string $language = 'UA',
        $holdTimeout = null,
        $merchantAuthType = null,
        $socialUri = null
    ) {
        parent::__construct($credential);

        if ($merchantTransactionType && !in_array($merchantTransactionType, $this->merchantTransactionTypeAllowed)) {
            throw new \InvalidArgumentException(
                'Unexpected transaction type, expected ' . implode(', ', $this->merchantTransactionTypeAllowed)
                . ', got ' . $merchantTransactionType
            );
        }

        if ($merchantTransactionSecureType && !in_array($merchantTransactionSecureType, $this->merchantTransactionSecureTypeAllowed)) {
            throw new \InvalidArgumentException(
                'Unexpected transaction secure type, expected ' . implode(', ', $this->merchantTransactionSecureTypeAllowed)
                . ', got ' . $merchantTransactionSecureType
            );
        }

        if ($merchantAuthType && !in_array($merchantAuthType, $this->merchantAuthTypeAllowed)) {
            throw new \InvalidArgumentException(
                'Unexpected auth type, expected ' . implode(', ', $this->merchantAuthTypeAllowed)
                . ', got ' . $merchantAuthType
            );
        }

        if (strlen($currency) !== 3) {
            throw new \InvalidArgumentException('Currency must contain 3 chars');
        }

        $this->merchantAuthType = (string) $merchantAuthType;
        $this->merchantDomainName = (string) $merchantDomainName;
        $this->merchantTransactionType = (string) $merchantTransactionType;
        $this->merchantTransactionSecureType = (string) $merchantTransactionSecureType;
        $this->serviceUrl = (string) $serviceUrl;
        $this->orderReference = (string) $orderReference;
        $this->orderDate = $orderDate;
        $this->amount = (float) $amount;
        $this->currency = strtoupper((string) $currency);
        $this->holdTimeout = (int) $holdTimeout;
        $this->products = $products;
        $this->client = $client ?: new Client();
        $this->socialUri = (string) $socialUri;
        $this->returnUrl = $returnUrl;
        $this->language = $language;
        $this->setEndpoint(new PayEndpoint());
    }

    public function getRequestSignatureFieldsValues()
    {
        return array_merge(parent::getRequestSignatureFieldsValues(), [
            'merchantDomainName' => $this->merchantDomainName,
            'orderReference' => $this->orderReference,
            'orderDate' => $this->orderDate->getTimestamp(),
            'amount' => $this->amount,
            'currency' => $this->currency,
            'products' => $this->products
        ]);
    }

    public function getTransactionData()
    {
        $data = array_merge(parent::getTransactionData(), [
            'merchantAuthType' => $this->merchantAuthType,
            'merchantDomainName' => $this->merchantDomainName,
            'merchantTransactionType' => $this->merchantTransactionType,
            'merchantTransactionSecureType' => $this->merchantTransactionSecureType,
            'serviceUrl' => $this->serviceUrl,
            'returnUrl' => $this->returnUrl,
            'language' => $this->language,
            'orderReference' => $this->orderReference,
            'orderDate' => $this->orderDate->getTimestamp(),
            'amount' => $this->amount,
            'currency' => $this->currency,
            'holdTimeout' => $this->holdTimeout,
            'socialUri' => $this->socialUri,

            'clientAccountId' => $this->client->getId(),
            'clientFirstName' => $this->client->getNameFirst(),
            'clientLastName' => $this->client->getNameLast(),
            'clientEmail' => $this->client->getEmail(),
            'clientPhone' => $this->client->getPhone(),
            'clientCountry' => $this->client->getCountry(),
            'clientIpAddress' => $this->client->getIp(),
            'clientAddress' => $this->client->getAddress(),
            'clientCity' => $this->client->getCity(),
            'clientState' => $this->client->getState(),

            'productName' => $this->products->getNames(),
            'productPrice' => $this->products->getPrices(),
            'productCount' => $this->products->getCounts(),
        ]);

        return $data;
    }

    public function getResponseSignatureFieldsRequired()
    {
        return ['url'];
    }

    public function getResponseClass()
    {
        return PurchaseResponse::class;
    }

    public function getTransactionType()
    {
        return 'PURCHASE';
    }

    public function getResponse(array $data)
    {
        $class = $this->getResponseClass();
        $response = new $class($data);
        return $response;
    }
}
