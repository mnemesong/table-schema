<?php

namespace Mnemesong\TableSchema\helpers;

use Mnemesong\TableSchema\columns\BoolColumnSchema;
use Mnemesong\TableSchema\columns\FloatColumnSchema;
use Mnemesong\TableSchema\columns\IntegerColumnSchema;
use Mnemesong\TableSchema\columns\StringColumnSchema;

class ColumnsHelper
{
    /**
     * @return class-string[]
     */
    public static function typesAssociation(): array
    {
        return [
            'bool' => BoolColumnSchema::class,
            'float' => FloatColumnSchema::class,
            'int' => IntegerColumnSchema::class,
            'string' => StringColumnSchema::class,
        ];
    }

    /**
     * @param string $type
     * @return class-string
     */
    public static function classByType(string $type): ?string
    {
        if(!isset(static::typesAssociation()[$type])) {
            return null;
        }
        return static::typesAssociation()[$type];
    }

    /**
     * @param class-string $class
     * @return string|null
     * @throws \ErrorException
     */
    public static function typeByClass(string $class): ?string
    {
        $allowed = array_filter(static::typesAssociation(), fn(string $val) => ($val === $class));
        if(empty($allowed)) {
            return null;
        } elseif (count($allowed) > 1) {
            throw new \ErrorException('Invalid types to classes association: class ' . $class . ' associated with'
                . 'many types: ' . implode(', ', $allowed));
        }
        return current(array_keys($allowed));
    }
}