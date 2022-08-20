<?php

namespace Mnemesong\TableSchemaTestUnit\stubs;

use Mnemesong\TableSchema\columns\BoolColumnSchema;
use Mnemesong\TableSchema\columns\ColumnSchema;
use Mnemesong\TableSchemaStubs\ColumnSchemaStub;
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
     * @return ColumnSchema
     */
    protected function getInitializedColumnSchema(string $name): ColumnSchema
    {
        return new ColumnSchemaStub($name);
    }

    /**
     * @return void
     */
    public function testTryToCast(): void
    {
        $col = $this->getInitializedColumnSchema('someCol');
        $col = ColumnSchemaStub::assertClass($col);
        $this->assertEquals(ColumnSchemaStub::class, get_class($col));
    }

    /**
     * @return void
     */
    public function testTryToCastException(): void
    {
        $col = new BoolColumnSchema('active');
        $this->expectException(\InvalidArgumentException::class);
        $col = ColumnSchemaStub::assertClass($col);
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