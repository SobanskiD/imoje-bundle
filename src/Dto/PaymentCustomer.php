<?php
declare(strict_types=1);

namespace Sobanski\ImojeBundle\Dto;

final readonly class PaymentCustomer
{

    public function __construct(
        public string $firstName,
        public string $lastName,
        public string $email,
    ){}

    public function toArray(): array
    {
        return [
                'firstName' => $this->firstName,
                'lastName' => $this->lastName,
                'email' => $this->email
        ];
    }


}