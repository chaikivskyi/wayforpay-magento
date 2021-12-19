<?php
declare(strict_types=1);

namespace Pich\WayForPay\Gateway\Http;

use Magento\Payment\Gateway\Http\TransferBuilder;
use Magento\Payment\Gateway\Http\TransferInterface;
use Pich\WayForPay\Gateway\Config\Config;
use Magento\Payment\Gateway\Http\ConverterInterface;

class TransferFactory implements \Magento\Payment\Gateway\Http\TransferFactoryInterface
{
    private TransferBuilder $transferBuilder;

    public function __construct(TransferBuilder $transferBuilder)
    {
        $this->transferBuilder = $transferBuilder;
    }

    public function create(array $request)
    {
        return $this->transferBuilder
            ->setBody($request)
            ->build();
    }
}
