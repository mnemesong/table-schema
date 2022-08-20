<?php

namespace Mnemesong\TableSchemaTestUnit\stubs;

use Mnemesong\TableSchema\columns\BoolAbstractColumnSchema;
use Mnemesong\TableSchema\columns\AbstractColumnSchema;
use Mnemesong\TableSchemaStubs\AbstractColumnSchemaStub;
use Mnemesong\TableSchemaTestHelpers\ColumnSchemaTestTrait;
use PHPUnit\Framework\TestCase;

class ColumnsSchemaTest extends TestCase
{
    use ColumnSchemaTestTrait;

    /**
     * @return TestCase
     */
    protected function useTestCase(): TestCase
    {
        return $this;
    }

    /**
     * @param string $name
     * @return AbstractColumnSchema
     */
    protected function getInitializedColumnSchema(string $name): AbstractColumnSchema
    {
        return new AbstractColumnSchemaStub($name);
    }

    /**
     * @return void
     */
    public function testTryToCast(): void
    {
        $col = $this->getInitializedColumnSchema('someCol');
        $col = AbstractColumnSchemaStub::tryToCastFrom($col);
        $this->assertEquals(AbstractColumnSchemaStub::class, get_class($col));
    }

    /**
     * @return void
     */
    public function testTryToCastException(): void
    {
        $col = new BoolAbstractColumnSchema('active');
        $this->expectException(\InvalidArgumentException::class);
        $col = AbstractColumnSchemaStub::tryToCastFrom($col);
    }

    /**
     * @return void
     */
    public function testGetType(): void
    {
        $col = $this->getInitializedColumnSchema('someCol');
        $this->assertEquals('stub', $col->getType());
    }
}