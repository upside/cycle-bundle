<?php

namespace Upside\CycleOrmBundle;

use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Upside\CycleOrmBundle\DependencyInjection\Compiler\SchemaCompilerPass;

class CycleOrmBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }

    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new SchemaCompilerPass(), PassConfig::TYPE_OPTIMIZE);
    }

}
