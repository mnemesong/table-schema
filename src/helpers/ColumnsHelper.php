<?php

namespace Mnemesong\TableSchema\helpers;

use Mnemesong\TableSchema\columns\BoolAbstractColumnSchema;
use Mnemesong\TableSchema\columns\FloatAbstractColumnSchema;
use Mnemesong\TableSchema\columns\IntegerAbstractColumnSchema;
use Mnemesong\TableSchema\columns\StringAbstractColumnSchema;

class ColumnsHelper
{
    /**
     * @return class-string[]
     */
    public static function typesAssociation(): array
    {
        return [
            'bool' => BoolAbstractColumnSchema::class,
            'float' => FloatAbstractColumnSchema::class,
            'int' => IntegerAbstractColumnSchema::class,
            'string' => StringAbstractColumnSchema::class,
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