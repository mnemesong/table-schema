<?php

namespace Mnemesong\TableSchemaTestUnit\stubs;

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
    public function testTypeChecks(): void
    {
        $schema1 = $this->getInitializedColumnSchema('age');
        $this->assertEquals(false, $schema1->isBoolColumn());
        $this->assertEquals(false, $schema1->isIntegerColumn());
        $this->assertEquals(false, $schema1->isFloatColumn());
        $this->assertEquals(false, $schema1->isStringColumn());
    }

    /**
     * @return void
     */
    public function testCastToBool(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->getInitializedColumnSchema('age')->castToBoolColumn();
    }

    /**
     * @return void
     */
    public function testCastToInteger(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->getInitializedColumnSchema('age')->castToIntegerColumn();
    }

    /**
     * @return void
     */
    public function testCastToString(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->getInitializedColumnSchema('age')->castToStringColumn();
    }

    /**
     * @return void
     */
    public function testCastToFloat(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->getInitializedColumnSchema('age')->castToFloatColumn();
    }
}