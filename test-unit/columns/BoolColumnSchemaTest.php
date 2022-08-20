<?php

namespace Mnemesong\TableSchemaTestUnit\columns;

use Mnemesong\TableSchema\columns\BoolColumnSchema;
use Mnemesong\TableSchema\columns\ColumnSchema;
use Mnemesong\TableSchema\columns\StringColumnSchema;
use Mnemesong\TableSchemaStubs\ColumnSchemaStub;
use Mnemesong\TableSchemaTestHelpers\ColumnSchemaTestTrait;
use PHPUnit\Framework\TestCase;

class BoolColumnSchemaTest extends TestCase
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
        return new BoolColumnSchema($name);
    }

    /**
     * @return void
     */
    public function testDefault(): void
    {
        $col1 = new BoolColumnSchema('updated');
        $this->assertEquals(null, $col1->getDefaultValue());

        $col2 = $col1->withDefaultValue(true);
        $this->assertEquals(null, $col1->getDefaultValue());
        $this->assertEquals(true, $col2->getDefaultValue());

        $col3 = $col2->withoutDefaultValue();
        $this->assertEquals(null, $col3->getDefaultValue());
        $this->assertEquals(true, $col2->getDefaultValue());
    }

    /**
     * @return void
     */
    public function testTryToCast(): void
    {
        $col = $this->getInitializedColumnSchema('column');
        $col = BoolColumnSchema::tryToCastFrom($col);
        $this->assertTrue(is_a($col, BoolColumnSchema::class));
    }

    /**
     * @return void
     */
    public function testTryToCastException(): void
    {
        $col = new StringColumnSchema('name');
        $this->expectException(\InvalidArgumentException::class);
        $col = BoolColumnSchema::tryToCastFrom($col);
    }

    /**
     * @return void
     */
    public function testGetType(): void
    {
        $col = $this->getInitializedColumnSchema('isActive');
        $this->assertEquals('bool', $col->getType());
    }
}