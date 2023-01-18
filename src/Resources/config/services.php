<?php

use Cycle\Database;
use Cycle\ORM;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Upside\CycleOrmBundle\DatabaseConfigFactory;
use Upside\CycleOrmBundle\SchemaFactory;
use function Symfony\Component\DependencyInjection\Loader\Configurator\abstract_arg;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return static function (ContainerConfigurator $container) {

    $services = $container->services();

    $services
        ->set(Database\Config\DatabaseConfig::class)
        ->args([abstract_arg('Cycle database config')])
        ->factory([DatabaseConfigFactory::class, 'create']);
    $services
        ->set(Database\DatabaseManager::class)
        ->autowire()
        ->alias(Database\DatabaseProviderInterface::class, service(Database\DatabaseManager::class));


    $services->set(ORM\Factory::class)
        ->autowire()
        ->alias(ORM\FactoryInterface::class, service(ORM\Factory::class));
    $services->set(ORM\Schema::class)
        ->args([abstract_arg('Cycle orm schema config')])
        ->factory([SchemaFactory::class, 'create'])
        ->autowire()
        ->alias(ORM\SchemaInterface::class, service(ORM\Schema::class));
    $services
        ->set(ORM\ORM::class)
        ->autowire()
        ->alias(ORM\ORMInterface::class, service(ORM\ORM::class));
    $services
        ->set(ORM\EntityManager::class)
        ->autowire();
};
