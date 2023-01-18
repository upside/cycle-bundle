<?php

namespace Upside\CycleOrmBundle;

use Cycle\Annotated\Embeddings;
use Cycle\Annotated\Entities;
use Cycle\Database\DatabaseManager;
use Spiral\Tokenizer\ClassLocator;
use Symfony\Component\Finder\Finder;
use Cycle\Schema;

class SchemaCompiler
{
    private DatabaseManager $databaseManager;
    private array $entityPaths;
    private array $generatorClasses;

    public function __construct(DatabaseManager $databaseManager, array $entityPaths, array $generatorClasses)
    {
        $this->databaseManager = $databaseManager;
        $this->entityPaths = $entityPaths;
        $this->generatorClasses = $generatorClasses;
    }

    public function compile(): array
    {
        $finder = (new Finder())->files()->in($this->entityPaths);
        $classLocator = new ClassLocator($finder);

        $generators = [];
        foreach ($this->generatorClasses as $generatorClass) {
            if ($generatorClass === Embeddings::class || $generatorClass === Entities::class) {
                $generators[] = new $generatorClass($classLocator);
                continue;
            }
            $generators[] = new $generatorClass();
        }

        return (new Schema\Compiler())->compile(new Schema\Registry($this->databaseManager), $generators);
    }
}
