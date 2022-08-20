<?php

namespace Mnemesong\TableSchemaStubs;

use Mnemesong\TableSchema\columns\AbstractColumnSchema;
use Webmozart\Assert\Assert;

final class AbstractColumnSchemaStub extends AbstractColumnSchema
{
    /**
     * @return string
     */
    public function getType(): string
    {
        return 'stub';
    }

    /**
     * @param AbstractColumnSchema $schema
     * @return AbstractColumnSchemaStub
     */
    static public function tryToCastFrom(AbstractColumnSchema $schema): AbstractColumnSchemaStub
    {
        Assert::isAOf($schema, AbstractColumnSchemaStub::class);
        /* @var AbstractColumnSchemaStub $schema */
        return $schema;
    }
}