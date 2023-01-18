<?php

namespace Upside\CycleOrmBundle\DependencyInjection\Compiler;

use Cycle\Database\DatabaseManager;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Upside\CycleOrmBundle\DependencyInjection\Configuration;
use Upside\CycleOrmBundle\SchemaCompiler;

class SchemaCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->hasDefinition(DatabaseManager::class)) {
            return;
        }

        $parameterBag = $container->getParameterBag();
        $processor = new Processor();
        $configuration = new Configuration();

        $configs = $processor->processConfiguration(
            $configuration,
            $parameterBag->resolveValue($container->getExtensionConfig('cycle_orm'))
        );

        /** @var DatabaseManager $databaseManager */
        $databaseManager = $container->get(DatabaseManager::class);

        $schemaCompiler = new SchemaCompiler(
            $databaseManager,
            $configs['orm']['entityPaths'],
            $configs['orm']['compileGenerators']
        );

        $schema = $schemaCompiler->compile();

        file_put_contents($configs['orm']['schemaCachePath'], '<?php return ' . var_export($schema, true) . ';');
    }
}
