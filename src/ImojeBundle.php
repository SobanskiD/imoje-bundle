<?php
declare(strict_types=1);

namespace Sobanski\ImojeBundle;

use Sobanski\ImojeBundle\Config\ImojeConfig;
use Symfony\Component\Config\Definition\Configurator\DefinitionConfigurator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

final class ImojeBundle extends AbstractBundle
{

    public function configure(DefinitionConfigurator $definition): void
    {
        $definition->rootNode()
            ->children()
                ->scalarNode('merchant_id')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('service_id')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('service_key')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('api_token')->isRequired()->cannotBeEmpty()->end()
                ->booleanNode('sandbox')->defaultTrue()->end()
            ->end();
    }

    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        $container->import('../config/services.php');

        $container->services()
            ->get(ImojeConfig::class)
            ->arg('$merchantId', $config['merchant_id'])
            ->arg('$serviceId', $config['service_id'])
            ->arg('$serviceKey', $config['service_key'])
            ->arg('$apiToken', $config['api_token'])
            ->arg('$sandbox', $config['sandbox']);
    }

}