<?php
declare(strict_types=1);

namespace Pich\WayForPay\Model\Sdk\Domain;

class Checkout
{
    private string $url;

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public static function fromArray(array $data)
    {
        return new self($data['url']);
    }
}
