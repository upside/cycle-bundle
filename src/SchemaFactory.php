<?php

namespace Upside\CycleOrmBundle;

use Cycle\Database\DatabaseManager;
use Cycle\ORM\Schema;

class SchemaFactory
{
    public static function create(DatabaseManager $databaseManager, array $config): Schema
    {
        if ($config['schemaCache']) {
            $scheme = require $config['schemaCachePath'];
        } else {
            $schemaCompiler = new SchemaCompiler(
                $databaseManager,
                $config['entityPaths'],
                $config['compileGenerators']
            );

            $scheme = $schemaCompiler->compile();
        }

        return new Schema($scheme);
    }
}
