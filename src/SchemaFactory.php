<?php

namespace Upside\CycleOrmBundle;

use Cycle\ORM\Schema;

class SchemaFactory
{
    public static function create(array $config): Schema
    {
        $scheme = [];
        if ($config['schemaCache']) {
            $scheme = require $config['schemaCachePath'];
        }

        return new Schema($scheme);
    }
}
