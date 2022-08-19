<?php

namespace Mnemesong\TableSchemaStubs;

use Mnemesong\TableSchema\columns\ColumnSchema;

class ColumnSchemaStub extends ColumnSchema
{
    /**
     * @return bool
     */
    public function isIntegerColumn(): bool
    {
        return false;
    }

    /**
     * @return bool
     */
    public function isStringColumn(): bool
    {
        return false;
    }

    /**
     * @return bool
     */
    public function isBoolColumn(): bool
    {
        return false;
    }

    /**
     * @return bool
     */
    public function isFloatColumn(): bool
    {
        return false;
    }
}