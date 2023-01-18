<?php

namespace Upside\CycleOrmBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{

    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('cycle_orm');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->arrayNode('dbal')
                    ->children()
                        ->scalarNode('default')->end()
                        ->arrayNode('aliases')->end()
                        ->arrayNode('databases')
                            ->children()
                                ->arrayNode('default')
                                    ->children()
                                        ->scalarNode('connection')->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('connections')
                            ->prototype('array')
                                ->prototype('array')
                                    ->children()
                                        ->arrayNode('connection')
                                            ->prototype('array')
                                                ->children()
                                                    ->scalarNode('database')->cannotBeEmpty()->end()
                                                    ->scalarNode('host')->end()
                                                    ->integerNode('port')->end()
                                                    ->scalarNode('user')->defaultNull()->end()
                                                    ->scalarNode('password')->defaultNull()->end()
                                                    ->arrayNode('options')->end()
                                                    ->scalarNode('charset')->cannotBeEmpty()->end()
                                                    ->scalarNode('dsn')->cannotBeEmpty()->end()
                                                    ->scalarNode('socket')->cannotBeEmpty()->end()
                                                    ->scalarNode('app')->end()
                                                    ->scalarNode('pooling')->end()
                                                    ->scalarNode('encrypt')->end()
                                                    ->scalarNode('failover')->end()
                                                    ->scalarNode('timeout')->defaultNull()->end()
                                                    ->scalarNode('mars')->end()
                                                    ->scalarNode('quoted')->end()
                                                    ->scalarNode('traceFile')->end()
                                                    ->scalarNode('trace')->end()
                                                    ->scalarNode('isolation')->end()
                                                    ->scalarNode('trustServerCertificate')->end()
                                                    ->scalarNode('wsid')->end()
                                                ->end()
                                            ->end()
                                        ->end()
                                        ->scalarNode('schema')->end()
                                        ->scalarNode('driver')->end()
                                        ->booleanNode('reconnect')->end()
                                        ->scalarNode('timezone')->end()
                                        ->booleanNode('queryCache')->end()
                                        ->booleanNode('readonlySchema')->end()
                                        ->booleanNode('readonly')->end()
                                        ->arrayNode('options')->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
        $rootNode
            ->children()
                ->arrayNode('orm')
                    ->children()
                        ->booleanNode('schemaCache')->end()
                        ->scalarNode('schemaCachePath')->end()
                        ->arrayNode('entityPaths')
                            ->scalarPrototype()->end()
                        ->end()
                        ->arrayNode('compileGenerators')
                            ->scalarPrototype()->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
        return $treeBuilder;
    }
}
