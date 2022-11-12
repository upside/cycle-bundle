<?php

namespace Upside\CycleOrmBundle;

use Cycle\Database\Config\DatabaseConfig;
use Cycle\Database\Config\MySQLDriverConfig;
use Cycle\Database\Config\PostgresDriverConfig;
use Cycle\Database\Config\SQLiteDriverConfig;
use Cycle\Database\Config\SQLServerDriverConfig;
use Cycle\Database\Driver\MySQL\MySQLDriver;
use Cycle\Database\Driver\Postgres\PostgresDriver;
use Cycle\Database\Driver\SQLite\SQLiteDriver;
use Cycle\Database\Driver\SQLServer\SQLServerDriver;
use Cycle\Database\Config;

class DatabaseConfigFactory
{
    public static function create(array $configs): DatabaseConfig
    {
        $databaseConfig = [
            'default' => $configs['default'] ?? DatabaseConfig::DEFAULT_DATABASE,
            'aliases' => $configs['aliases'] ?? [],
            'databases' => $configs['databases'] ?? [],
            'connections' => [],
        ];

        foreach ($configs['connections'] as $connectionName => $connection) {
            $driverConfig = match ($connection['driver']) {
                MySQLDriver::class => self::createMySQLDriverConfig($connection),
                PostgresDriver::class => self::createPostgresDriverConfig($connection),
                SQLiteDriver::class => self::createSQLiteDriverConfig($connection),
                SQLServerDriver::class => self::createSQLServerDriverConfig($connection),
                default => throw new \RuntimeException('undefined driver')
            };

            $databaseConfig['connections'][$connectionName] = $driverConfig;
        }

        return new DatabaseConfig($databaseConfig);
    }

    private static function createMySQLDriverConfig(array $configs): MySQLDriverConfig
    {
        return new MySQLDriverConfig(
            connection: new Config\MySQL\TcpConnectionConfig(
                database: 'uchat',
                host: '127.0.0.1',
                port: 5432,
                user: 'postgres',
                password: 'postgres',
            ),
            queryCache: true,
        );
    }

    private static function createPostgresDriverConfig(array $configs): PostgresDriverConfig
    {
        return new PostgresDriverConfig(
            connection: new Config\Postgres\TcpConnectionConfig(
                database: 'uchat',
                host: '127.0.0.1',
                port: 5432,
                user: 'postgres',
                password: 'postgres',
            ),
            schema: 'public',
            queryCache: true,
        );
    }

    private static function createSQLiteDriverConfig(array $configs): SQLiteDriverConfig
    {
        return new SQLiteDriverConfig(
            connection: new Config\SQLite\DsnConnectionConfig('sd'),
            queryCache: true,
        );
    }

    private static function createSQLServerDriverConfig(array $configs): SQLServerDriverConfig
    {
        return new SQLServerDriverConfig(
            connection: new Config\SQLServer\TcpConnectionConfig(
                database: 'uchat',
                host: '127.0.0.1',
                port: 5432,
                user: 'postgres',
                password: 'postgres',
            ),
            queryCache: true,
        );
    }
}