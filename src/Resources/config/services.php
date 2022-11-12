<?php

use Cycle\Database\Config\DatabaseConfig;
use Cycle\Database\DatabaseManager;
use Cycle\ORM\ORM;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Upside\CycleOrmBundle\DatabaseConfigFactory;
use function Symfony\Component\DependencyInjection\Loader\Configurator\abstract_arg;

return static function (ContainerConfigurator $container) {
    $container
        ->services()
        ->set(DatabaseConfig::class)
            ->factory([DatabaseConfigFactory::class, 'create'])
            ->args([abstract_arg('Cycle database config')])
        ->set(DatabaseManager::class)
        ->set(ORM::class)
            ->arg('$schema', abstract_arg('Cycle orm schema'))

    ;
};