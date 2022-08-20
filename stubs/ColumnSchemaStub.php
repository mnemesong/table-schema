<?php

namespace Mnemesong\TableSchemaStubs;

use Mnemesong\TableSchema\columns\ColumnSchema;
use Webmozart\Assert\Assert;

final class ColumnSchemaStub extends ColumnSchema
{
    /**
     * @return string
     */
    public function getType(): string
    {
        return 'stub';
    }

    /**
     * @param ColumnSchema $schema
     * @return ColumnSchemaStub
     */
    static public function tryToCastFrom(ColumnSchema $schema): ColumnSchemaStub
    {
        Assert::isAOf($schema, ColumnSchemaStub::class);
        /* @var ColumnSchemaStub $schema */
        return $schema;
    }
}