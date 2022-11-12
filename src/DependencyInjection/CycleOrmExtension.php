<?php

namespace Upside\CycleOrmBundle\DependencyInjection;

use Cycle\Database\Config\DatabaseConfig;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

class CycleOrmExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new PhpFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.php');

        // $configuration = $this->getConfiguration($configs, $container);

        // $config = $this->processConfiguration($configuration, $configs);

        $this->prepareDatabaseConfig($configs, $container);
    }

    private function prepareDatabaseConfig(array $configs, ContainerBuilder $container): void
    {
        $container->getDefinition(DatabaseConfig::class)->replaceArgument(0, $configs['dbal']);
    }
}