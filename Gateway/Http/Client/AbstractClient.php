<?php
declare(strict_types=1);

namespace Pich\WayForPay\Gateway\Http\Client;

use Magento\Payment\Gateway\Http\ClientException;
use Magento\Payment\Gateway\Http\ClientInterface;
use Magento\Payment\Gateway\Http\TransferInterface;
use Magento\Payment\Model\Method\Logger;
use Pich\WayForPay\Api\AdapterInterface;
use Pich\WayForPay\Api\ApiFieldsInterface;

abstract class AbstractClient implements ClientInterface
{
    private Logger $paymentLogger;
    protected AdapterInterface $adapter;

    public function __construct(
        AdapterInterface $adapter,
        Logger $paymentLogger
    ) {
        $this->adapter = $adapter;
        $this->paymentLogger = $paymentLogger;
    }

    public function placeRequest(TransferInterface $transferObject)
    {
        $data = $transferObject->getBody();
        $log = [
            'request' => $data,
            'client' => static::class
        ];
        $response = [];

        try {
            $response = $this->process($data);
        } catch (\RuntimeException $e) {
            $response[ApiFieldsInterface::IS_PAYMENT_SUCCESS] = false;
            $response[ApiFieldsInterface::REASON_TEXT] = $e->getMessage();
            throw new ClientException(__('Payment data are invalid'));
        } catch (\Exception $e) {
            $message = __($e->getMessage() ?: 'Sorry, but something went wrong');
            $response[ApiFieldsInterface::IS_PAYMENT_SUCCESS] = false;
            $response[ApiFieldsInterface::REASON_TEXT] = $message;
            throw new ClientException($message);
        } finally {
            $log['response'] = $response;
            $this->paymentLogger->debug($log);
        }

        return $response;
    }

    abstract protected function process(array $data);
}
