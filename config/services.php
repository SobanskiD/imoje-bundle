<?php
declare(strict_types=1);

use Sobanski\ImojeBundle\Client\ImojeClient;
use Sobanski\ImojeBundle\Config\ImojeConfig;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return static function (ContainerConfigurator $container): void {
    $services = $container->services();
    $services->set(ImojeConfig::class);
    $services->set(ImojeClient::class)->args([
        service(ImojeConfig::class),
        service(HttpClientInterface::class),
        ]);
};