<?php

namespace Upside\CycleOrmBundle\DependencyInjection;

use Cycle\Database\Config\DatabaseConfig;
use Cycle\ORM\Schema;
use Exception;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

class CycleOrmExtension extends Extension
{
    /**
     * @param array $configs
     * @param ContainerBuilder $container
     * @return void
     * @throws Exception
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new PhpFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.php');

        $configuration = $this->getConfiguration($configs, $container);

        $config = $this->processConfiguration($configuration, $configs);

        $this->prepareDatabaseConfig($config['dbal'], $container);
        $this->prepareSchemeConfig($config['orm'], $container);
    }

    private function prepareDatabaseConfig(array $config, ContainerBuilder $container): void
    {
        $container->getDefinition(DatabaseConfig::class)->replaceArgument(0, $config);
    }

    private function prepareSchemeConfig(array $config, ContainerBuilder $container): void
    {
        $container->getDefinition(Schema::class)->replaceArgument(0, $config);
    }
}
