<?php
declare(strict_types=1);

namespace Sobanski\ImojeBundle\Client;

use Sobanski\ImojeBundle\Config\ImojeConfig;
use Sobanski\ImojeBundle\Dto\CreatePaymentRequest;
use Sobanski\ImojeBundle\Dto\PaymentResponse;
use Sobanski\ImojeBundle\ImojeApiException;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\HttpExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#Auto
final readonly class ImojeClient
{
    public function __construct(
        private ImojeConfig $config,
        private HttpClientInterface $httpClient,
    ){}

    public function createPayment(CreatePaymentRequest $request): PaymentResponse
    {
        $url = sprintf('%s/merchant/%s/payment', $this->config->getBaseUrl(), $this->config->merchantId);

        try {
            $response = $this->httpClient->request('POST', $url, [
                'headers' => [
                    'Authorization' => sprintf('Bearer %s', $this->config->apiToken),
                    'Content-Type' => 'application/json',
                ],
                'json' => $request->toArray($this->config->serviceId),
            ]);

            $data = $response->toArray();

        } catch (HttpExceptionInterface|TransportExceptionInterface|DecodingExceptionInterface $e){
            throw new ImojeApiException(
                message: sprintf('imoje API error: %s', $e->getMessage()),
                code: $e->getCode(),
                previous: $e,
            );
        }
        return PaymentResponse::fromArray($data);
    }

}