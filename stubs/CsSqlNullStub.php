<?php

namespace Mnemesong\TableSchemaStubs;

use Mnemesong\TableSchema\ColumnSettingInterface;

class CsSqlNullStub implements ColumnSettingInterface
{

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'sql:null';
    }

    /**
     * @return string[]
     */
    public function getIncompatibleKeys(): array
    {
        return [
            'sql:notNull',
        ];
    }
}