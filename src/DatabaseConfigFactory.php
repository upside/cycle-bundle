<?php

namespace Upside\CycleOrmBundle;

use Cycle\Database\Config\DatabaseConfig;

class DatabaseConfigFactory
{
    public static function create(array $config): DatabaseConfig
    {
        $config['connections'] = array_map(static function (array $connection) {

            $driverConfigClass = array_key_first($connection);
            $connectionConfigClass = array_key_first($connection[$driverConfigClass]['connection']);
            $connection[$driverConfigClass]['connection'] = new $connectionConfigClass(...$connection[$driverConfigClass]['connection'][$connectionConfigClass]);

            dump($connection, $driverConfigClass, $connectionConfigClass);

            return new $driverConfigClass(...$connection[$driverConfigClass]);
        }, $config['connections']);

        return new DatabaseConfig($config);
    }
}
