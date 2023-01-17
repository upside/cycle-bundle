<?php

use Cycle\Database\Config\DatabaseConfig;
use Cycle\Database\DatabaseManager;
use Cycle\ORM\ORM;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Upside\CycleOrmBundle\DatabaseConfigFactory;
use Upside\CycleOrmBundle\DependencyInjection\Compiler\SchemaCompilerPass;
use function Symfony\Component\DependencyInjection\Loader\Configurator\abstract_arg;

return static function (ContainerConfigurator $container) {
    $container
        ->services()
        ->set(DatabaseConfig::class)
            ->args([abstract_arg('Cycle database config')])
            ->factory([DatabaseConfigFactory::class, 'create'])
        ->set(DatabaseManager::class)
            ->autowire()
        ->set(ORM::class)
            ->arg('$schema', abstract_arg('Cycle orm schema'))
            ->autowire()
        /*->set(SchemaCompiler::class)
            ->autowire()*/

    ;
};
