<?php
declare(strict_types=1);

namespace Sobanski\ImojeBundle\Dto;

final readonly class CreatePaymentRequest
{
    public function __construct(
        public int $amount,
        public string $currency,
        public string $orderId,
        public PaymentCustomer $customer,
        public ?string $title = null,
        public ?string $returnUrl = null,
        public ?string $successReturnUrl = null,
        public ?string $failureReturnUrl = null,
        public ?string $notificationUrl = null,
        public ?int $validTo = null,
    ) {}

    public function toArray(string $serviceId) : array{
        return array_filter([
            'serviceId' => $serviceId,
            'amount' => $this->amount,
            'currency' => $this->currency,
            'orderId' => $this->orderId,
            'title' => $this->title,
            'returnUrl' => $this->returnUrl,
            'successReturnUrl' => $this->successReturnUrl,
            'failureReturnUrl' => $this->failureReturnUrl,
            'notificationUrl' => $this->notificationUrl,
            'validTo' => $this->validTo,
            'customer' => $this->customer->toArray(),
        ], static fn (mixed $value): bool => $value !== null);
    }

}