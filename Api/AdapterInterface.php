<?php

namespace Pich\WayForPay\Api;

interface AdapterInterface
{
    public function charge(array $data);
    public function purchase(array $data);
    public function refund(array $data);
}
