<?php
declare(strict_types=1);

namespace Pich\WayForPay\Model;

class UrlRegistry
{
    private $url;

    public function set(string $url)
    {
        $this->url = $url;
    }

    public function get(): ?string
    {
        return $this->url;
    }
}
