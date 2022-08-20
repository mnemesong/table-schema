<?php

namespace Mnemesong\TableSchemaTestUnit\columns;

use Mnemesong\TableSchema\columns\ColumnSchema;
use Mnemesong\TableSchema\columns\FloatColumnSchema;
use Mnemesong\TableSchema\columns\IntegerColumnSchema;
use Mnemesong\TableSchemaTestHelpers\ColumnSchemaTestTrait;
use PHPUnit\Framework\TestCase;

class IntegerColumnSchemaTest extends TestCase
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
        return new IntegerColumnSchema($name);
    }

    /**
     * @return void
     */
    public function testValueLimits(): void
    {
        $col1 = new IntegerColumnSchema('age');
        $this->assertEquals(null, $col1->getMaxValue());
        $this->assertEquals(null, $col1->getMinValue());

        $col2 = $col1->withValueLimits(-2, 15);
        $this->assertEquals(null, $col1->getMaxValue());
        $this->assertEquals(null, $col1->getMinValue());
        $this->assertEquals(15, $col2->getMaxValue());
        $this->assertEquals(-2, $col2->getMinValue());

        $col3 = $col2->withValueLimits(10, 5);
        $this->assertEquals(10, $col3->getMaxValue());
        $this->assertEquals(5, $col3->getMinValue());
        $this->assertEquals(15, $col2->getMaxValue());
        $this->assertEquals(-2, $col2->getMinValue());

        $col4 = $col3->withoutValueLimits();
        $this->assertEquals(10, $col3->getMaxValue());
        $this->assertEquals(5, $col3->getMinValue());
        $this->assertEquals(null, $col4->getMaxValue());
        $this->assertEquals(null, $col4->getMinValue());
    }

    /**
     * @return void
     */
    public function testDefaultValue(): void
    {
        $col1 = new IntegerColumnSchema('age');
        $this->assertEquals(null, $col1->getDefaultValue());

        $col2 = $col1->withDefaultValue(12);
        $this->assertEquals(null, $col1->getDefaultValue());
        $this->assertEquals(12, $col2->getDefaultValue());

        $col3 = $col2->withoutDefaultValue();
        $this->assertEquals(null, $col3->getDefaultValue());
        $this->assertEquals(12, $col2->getDefaultValue());
    }

    /**
     * @return void
     */
    public function testDefaultException1(): void
    {
        $col = new IntegerColumnSchema('age');
        $col = $col->withValueLimits(1, 10);
        $this->expectException(\InvalidArgumentException::class);
        $col = $col->withDefaultValue(0);
    }

    /**
     * @return void
     */
    public function testDefaultException2(): void
    {
        $col = new IntegerColumnSchema('age');
        $col = $col->withValueLimits(1, 10);
        $this->expectException(\InvalidArgumentException::class);
        $col = $col->withDefaultValue(11);
    }

    /**
     * @return void
     */
    public function testDefaultException3(): void
    {
        $col = new IntegerColumnSchema('age');
        $col = $col->withDefaultValue(11);
        $this->expectException(\InvalidArgumentException::class);
        $col = $col->withValueLimits(1, 10);
    }

    /**
     * @return void
     */
    public function testTryToCast(): void
    {
        $col = $this->getInitializedColumnSchema('employeesNum');
        $col = IntegerColumnSchema::tryToCastFrom($col);
        $this->assertTrue(is_a($col, IntegerColumnSchema::class));
    }

    /**
     * @return void
     */
    public function testTryToCastException(): void
    {
        $col = new FloatColumnSchema('distance');
        $this->expectException(\InvalidArgumentException::class);
        $col = IntegerColumnSchema::tryToCastFrom($col);
    }

    /**
     * @return void
     */
    public function testGetType(): void
    {
        $col = $this->getInitializedColumnSchema('count');
        $this->assertEquals('int', $col->getType());
    }
}