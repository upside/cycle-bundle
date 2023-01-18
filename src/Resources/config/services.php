<?php

use Cycle\Database\Config\DatabaseConfig;
use Cycle\Database\DatabaseManager;
use Cycle\Database\DatabaseProviderInterface;
use Cycle\ORM\EntityManager;
use Cycle\ORM\Factory;
use Cycle\ORM\FactoryInterface;
use Cycle\ORM\ORM;
use Cycle\ORM\ORMInterface;
use Cycle\ORM\Schema;
use Cycle\ORM\SchemaInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Upside\CycleOrmBundle\DatabaseConfigFactory;
use Upside\CycleOrmBundle\SchemaFactory;
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
        ->alias(DatabaseProviderInterface::class, service(DatabaseManager::class))
        ->set(Factory::class)
            ->autowire()
        ->alias(FactoryInterface::class, service(Factory::class))
        ->set(Schema::class)
            ->args([abstract_arg('Cycle orm schema config')])
            ->factory([SchemaFactory::class, 'create'])
            ->autowire()
        ->alias(SchemaInterface::class, service(Schema::class))
        ->set(ORM::class)
            ->autowire()
        ->alias(ORMInterface::class, service(ORM::class))
        ->set(EntityManager::class)
            ->autowire()
    ;
};
