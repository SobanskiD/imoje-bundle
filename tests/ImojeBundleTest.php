<?php
declare(strict_types=1);

namespace Sobanski\ImojeBundle\Tests;

use PHPUnit\Framework\TestCase;
use Sobanski\ImojeBundle\Config\ImojeConfig;
use Sobanski\ImojeBundle\ImojeBundle;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ImojeBundleTest extends TestCase
{
    public function testLoadsConfigWithDefaultSandbox(): void
    {
        $config = $this->containerBuilder()->get(ImojeConfig::class);
        self::assertInstanceOf(ImojeConfig::class, $config);
        self::assertSame('dev_merchant', $config->merchantId);
        self::assertSame('dev_service', $config->serviceId);
        self::assertSame('dev_key', $config->serviceKey);
        self::assertSame('dev_api_token', $config->apiToken);
        self::assertTrue($config->sandbox);
        self::assertSame('https://sandbox.api.imoje.pl/v1', $config->getBaseUrl());

    }

    public function testLoadsProductConfig(): void
    {
        $config = $this->containerBuilder(['sandbox'=>false])->get(ImojeConfig::class);
        self::assertFalse($config->sandbox);
        self::assertSame('https://api.imoje.pl/v1', $config->getBaseUrl());
    }

    public function testThrowsExceptionWhenRequiredConfigIsMissing(): void
    {
        $this->expectException(InvalidConfigurationException::class);
         $this->containerBuilder(['merchant_id'=>null]);
    }

    /**
     * @return array<string, string>
     */
    private function configProvider(array $overrides = []): array
    {
        return array_merge([
            'merchant_id' => 'dev_merchant',
            'service_id' => 'dev_service',
            'service_key' => 'dev_key',
            'api_token' => 'dev_api_token',
        ], $overrides);
    }

    private function containerBuilder(array $overrides = []): ContainerBuilder
    {
        $container = new ContainerBuilder();
        $container->setParameter('kernel.environment', 'dev');
        $container->setParameter('kernel.build_dir', sys_get_temp_dir());


        $extension = (new ImojeBundle())->getContainerExtension();
        $extension->load([$this->configProvider($overrides)], $container);

        $container->getDefinition(ImojeConfig::class)->setPublic(true);
        $container->compile();

        return $container;
    }

}