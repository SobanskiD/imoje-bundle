<?php
declare(strict_types=1);

use Sobanski\ImojeBundle\Config\ImojeConfig;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $container): void {
    $services = $container->services();
    $services->set(ImojeConfig::class);
};