<?php

namespace Upside\CycleOrmBundle\DependencyInjection\Compiler;

use Cycle\Annotated\Embeddings;
use Cycle\Annotated\Entities;
use Cycle\Database\DatabaseManager;
use Cycle\Schema;
use Spiral\Tokenizer\ClassLocator;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Finder\Finder;
use Upside\CycleOrmBundle\DependencyInjection\Configuration;

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

        $schema = $this->compile(
            $container,
            $configs['orm']['entityPaths'],
            $configs['orm']['compileGenerators']
        );

        dd($schema);
    }

    private function compile(ContainerBuilder $container, array $entityPaths, $generatorClasses): array
    {
        $finder = new Finder();
        $databaseManager = $container->get(DatabaseManager::class);


        if (null === $databaseManager) {
            throw new \RuntimeException('databaseManager not found');
        }

        $finder = $finder->files()->in($entityPaths);
        $classLocator = new ClassLocator($finder);

        $generators = [];
        foreach ($generatorClasses as $generatorClass) {
            if ($generatorClass === Embeddings::class || $generatorClass === Entities::class) {
                $generators[] = new $generatorClass($classLocator);
                continue;
            }
            $generators[] = new $generatorClass();
        }

        return (new Schema\Compiler())->compile(new Schema\Registry($databaseManager), $generators);
    }
}
