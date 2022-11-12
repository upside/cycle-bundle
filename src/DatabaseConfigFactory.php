<?php

namespace Upside\CycleOrmBundle;

use Cycle\Database\Config\DatabaseConfig;

class DatabaseConfigFactory
{
    public static function create(array $config): DatabaseConfig
    {
        dump($config);
        return new DatabaseConfig($config);
    }

}