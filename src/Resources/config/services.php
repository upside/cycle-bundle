<?php

use Cycle\Database\Config\DatabaseConfig;
use Cycle\Database\DatabaseManager;
use Cycle\ORM\EntityManager;
use Cycle\ORM\ORM;
use Cycle\ORM\ORMInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Upside\CycleOrmBundle\DatabaseConfigFactory;
use function Symfony\Component\DependencyInjection\Loader\Configurator\abstract_arg;

return static function (ContainerConfigurator $container) {
    $container
        ->services()
        ->set(DatabaseConfig::class)
            ->args([abstract_arg('Cycle database config')])
            ->factory([DatabaseConfigFactory::class, 'create'])
        ->set(DatabaseManager::class)
            ->autowire()
        ->set(ORMInterface::class, ORM::class)
            ->arg('$schema', abstract_arg('Cycle orm schema'))
            ->autowire()
        ->set(EntityManager::class)
            ->autowire()
    ;
};
