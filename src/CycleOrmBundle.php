<?php

namespace Upside\CycleOrmBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class CycleOrmBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}