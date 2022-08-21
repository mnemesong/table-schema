<?php

namespace Mnemesong\TableSchemaStubs;

use Mnemesong\TableSchema\ColumnSettingInterface;

class CsSqlNotNullStub implements ColumnSettingInterface
{
    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'sql:notNull';
    }

    /**
     * @return string[]
     */
    public function getIncompatibleKeys(): array
    {
        return [
            'sql:null',
        ];
    }
}