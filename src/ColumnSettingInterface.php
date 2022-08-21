<?php

namespace Mnemesong\TableSchema;

interface ColumnSettingInterface
{
    /**
     * @return string
     */
    public function getKey(): string;

    /**
     * @return string[]
     */
    public function getIncompatibleKeys(): array;
}