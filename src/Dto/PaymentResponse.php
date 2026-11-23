<?php

declare(strict_types=1);

namespace Sobanski\ImojeBundle\Dto;

use Sobanski\ImojeBundle\ImojeApiException;

final readonly class PaymentResponse
{

    public function __construct(
        public string $id,
        public string $url,
        public string $orderId,
        public int $amount,
        public string $currency,
        public bool $isActive
    ){}

    public static function fromArray(array $data): self
    {
        if (!isset($data['payment']) || !is_array($data['payment'])) {
            throw new ImojeApiException('Invalid imoje API response: missing or invalid "payment" key.');
        }
        $payment = $data['payment'];

        return new self(
            $payment['id'],
            $payment['url'],
            $payment['orderId'],
            $payment['amount'],
            $payment['currency'],
            $payment['isActive'],
        );
    }

}