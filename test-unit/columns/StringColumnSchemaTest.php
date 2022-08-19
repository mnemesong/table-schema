<?php

namespace Mnemesong\TableSchemaTestUnit\columns;

use Mnemesong\TableSchema\columns\ColumnSchema;
use Mnemesong\TableSchema\columns\StringColumnSchema;
use Mnemesong\TableSchemaTestHelpers\ColumnSchemaTestTrait;
use PHPUnit\Framework\TestCase;

class StringColumnSchemaTest extends TestCase
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
        return new StringColumnSchema($name);
    }

    /**
     * @return void
     */
    public function testTypeChecks(): void
    {
        $col = $this->getInitializedColumnSchema('name');
        $this->assertEquals(false, $col->isBoolColumn());
        $this->assertEquals(true, $col->isStringColumn());
        $this->assertEquals(false, $col->isIntegerColumn());
        $this->assertEquals(false, $col->isFloatColumn());
    }

    /**
     * @return void
     */
    public function testCastToBool(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $sch = $this->getInitializedColumnSchema('avg')->castToBoolColumn();
    }

    /**
     * @return void
     */
    public function testCastToInteger(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $sch = $this->getInitializedColumnSchema('avg')->castToIntegerColumn();
    }

    /**
     * @return void
     */
    public function testCastToString(): void
    {
        $sch = $this->getInitializedColumnSchema('avg')->castToStringColumn();
        $this->assertEquals(StringColumnSchema::class, get_class($sch));
    }

    /**
     * @return void
     */
    public function testCastToFloat(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $sch = $this->getInitializedColumnSchema('avg')->castToFloatColumn();
    }

    /**
     * @return void
     */
    public function testLengthLimit(): void
    {
        $col1 = new StringColumnSchema('date');
        $this->assertEquals(null, $col1->getStringLengthLimit());

        $col2 = $col1->withStringLengthLimit(20);
        $this->assertEquals(null, $col1->getStringLengthLimit());
        $this->assertEquals(20, $col2->getStringLengthLimit());

        $col3 = $col2->withoutStringLengthLimit();
        $this->assertEquals(null, $col3->getStringLengthLimit());
        $this->assertEquals(20, $col2->getStringLengthLimit());
    }

    /**
     * @return void
     */
    public function testLengthLimitException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        (new StringColumnSchema('date'))->withStringLengthLimit(-1);
    }

    /**
     * @return void
     */
    public function testDefaultValue(): void
    {
        $col1 = new StringColumnSchema('name');
        $this->assertEquals(null, $col1->getDefaultValue());

        $col2 = $col1->withDefaultValue('');
        $this->assertEquals(null, $col1->getDefaultValue());
        $this->assertEquals('', $col2->getDefaultValue());

        $col3 = $col1->withDefaultValue('none');
        $this->assertEquals(null, $col1->getDefaultValue());
        $this->assertEquals('none', $col3->getDefaultValue());

        $col4 = $col3->withoutDefaultValue();
        $this->assertEquals(null, $col4->getDefaultValue());
        $this->assertEquals('none', $col3->getDefaultValue());
    }
}