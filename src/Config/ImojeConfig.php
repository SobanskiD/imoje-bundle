<?php
declare(strict_types=1);

namespace Sobanski\ImojeBundle\Config;

final readonly class ImojeConfig
{

    private const IMOJE_SANDBOX = "https://sandbox.api.imoje.pl/v1";
    private const IMOJE_PRODUCTION = "https://api.imoje.pl/v1";

    public function __construct(
        public  string $merchantId,
        public  string $serviceId,
        public   string $serviceKey,
        public  string $apiToken,
        public  bool $sandbox = true
    )
    {}

    public function getBaseUrl(): string
    {
        return $this->sandbox ? self::IMOJE_SANDBOX : self::IMOJE_PRODUCTION;
    }

}