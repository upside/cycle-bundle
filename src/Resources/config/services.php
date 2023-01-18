<?php

use Cycle\Database\Config\DatabaseConfig;
use Cycle\Database\DatabaseManager;
use Cycle\ORM\EntityManager;
use Cycle\ORM\Factory;
use Cycle\ORM\FactoryInterface;
use Cycle\ORM\ORM;
use Cycle\ORM\ORMInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Upside\CycleOrmBundle\DatabaseConfigFactory;
use function Symfony\Component\DependencyInjection\Loader\Configurator\abstract_arg;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return static function (ContainerConfigurator $container) {
    $container
        ->services()
        ->set(DatabaseConfig::class)
            ->args([abstract_arg('Cycle database config')])
            ->factory([DatabaseConfigFactory::class, 'create'])
        ->set(DatabaseManager::class)
            ->autowire()
        ->set(Factory::class)
            ->autowire()
        ->alias(FactoryInterface::class, service(Factory::class))
        ->set(ORM::class)
            ->arg('$schema', abstract_arg('Cycle orm schema'))
            ->autowire()
        ->alias(ORMInterface::class, service(ORM::class))
        ->set(EntityManager::class)
            ->autowire()
    ;
};
