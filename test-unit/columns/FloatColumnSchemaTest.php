<?php

namespace Mnemesong\TableSchemaTestUnit\columns;

use Mnemesong\TableSchema\columns\BoolColumnSchema;
use Mnemesong\TableSchema\columns\ColumnSchema;
use Mnemesong\TableSchema\columns\FloatColumnSchema;
use Mnemesong\TableSchema\columns\IntegerColumnSchema;
use Mnemesong\TableSchemaTestHelpers\ColumnSchemaTestTrait;
use PHPUnit\Framework\TestCase;

class FloatColumnSchemaTest extends TestCase
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
        return new FloatColumnSchema($name);
    }

    /**
     * @return void
     */
    public function testLimits(): void
    {
        $col1 = new FloatColumnSchema('maxVal');
        $this->assertEquals(null, $col1->getMaxValue());
        $this->assertEquals(null, $col1->getMinValue());

        $col2 = $col1->withValueLimits(0.2, 1.13);
        $this->assertEquals(null, $col1->getMaxValue());
        $this->assertEquals(null, $col1->getMinValue());
        $this->assertEquals(1.13, $col2->getMaxValue());
        $this->assertEquals(0.2, $col2->getMinValue());

        $col3 = $col2->withValueLimits(5.1, 1.15);
        $this->assertEquals(5.1, $col3->getMaxValue());
        $this->assertEquals(1.15, $col3->getMinValue());
        $this->assertEquals(1.13, $col2->getMaxValue());
        $this->assertEquals(0.2, $col2->getMinValue());

        $col4 = $col3->withoutValueLimits();
        $this->assertEquals(5.1, $col3->getMaxValue());
        $this->assertEquals(1.15, $col3->getMinValue());
        $this->assertEquals(null, $col4->getMaxValue());
        $this->assertEquals(null, $col4->getMinValue());
    }

    /**
     * @return void
     */
    public function testAccuracy(): void
    {
        $col1 = new FloatColumnSchema('maxVal');
        $this->assertEquals(0.0001, $col1->getAccuracy());

        $col2 = $col1->withAccuracy(0.02);
        $this->assertEquals(0.0001, $col1->getAccuracy());
        $this->assertEquals(0.02, $col2->getAccuracy());
    }

    /**
     * @return void
     */
    public function testDefault(): void
    {
        $col1 = new FloatColumnSchema('maxVal');
        $this->assertEquals(null, $col1->getDefaultValue());

        $col2 = $col1->withDefaultValue(0.11);
        $this->assertEquals(null, $col1->getDefaultValue());
        $this->assertEquals(0.11, $col2->getDefaultValue());

        $col3 = $col2->withoutDefaultValue();
        $this->assertEquals(null, $col3->getDefaultValue());
        $this->assertEquals(0.11, $col2->getDefaultValue());
    }

    /**
     * @return void
     */
    public function testDefaultException1(): void
    {
        $col = new FloatColumnSchema('metric');
        $col = $col->withValueLimits(1, 10);
        $this->expectException(\InvalidArgumentException::class);
        $col = $col->withDefaultValue(0.5);
    }

    /**
     * @return void
     */
    public function testDefaultException2(): void
    {
        $col = new FloatColumnSchema('metric');
        $col = $col->withValueLimits(1, 10);
        $this->expectException(\InvalidArgumentException::class);
        $col = $col->withDefaultValue(10.3);
    }

    /**
     * @return void
     */
    public function testDefaultException3(): void
    {
        $col = new FloatColumnSchema('metric');
        $col = $col->withDefaultValue(10.3);
        $this->expectException(\InvalidArgumentException::class);
        $col = $col->withValueLimits(1, 10);
    }

    /**
     * @return void
     */
    public function testTryToCast(): void
    {
        $col = $this->getInitializedColumnSchema('distance');
        $col = FloatColumnSchema::assertClass($col);
        $this->assertTrue(is_a($col, FloatColumnSchema::class));
    }

    /**
     * @return void
     */
    public function testTryToCastException(): void
    {
        $col = new IntegerColumnSchema('age');
        $this->expectException(\InvalidArgumentException::class);
        $col = FloatColumnSchema::assertClass($col);
    }

    /**
     * @return void
     */
    public function testGetType(): void
    {
        $col = $this->getInitializedColumnSchema('distance');
        $this->assertEquals('float', $col->getType());
    }
}