<?php

namespace Mnemesong\TableSchemaStubs;

use Mnemesong\TableSchema\ColumnSettingInterface;
use Webmozart\Assert\Assert;

final class CsDateTimeStub implements ColumnSettingInterface
{

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'sql:dateTime';
    }

    /**
     * @return string[]
     */
    public function getIncompatibleKeys(): array
    {
        return [];
    }
}