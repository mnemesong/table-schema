<?php

namespace Mnemesong\TableSchemaTestUnit\columns;

use Mnemesong\TableSchema\columns\BoolColumnSchema;
use Mnemesong\TableSchema\columns\ColumnSchema;
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
    public function testTypeChecks(): void
    {
        $sch = $this->getInitializedColumnSchema('isActive');
        $this->assertEquals(true, $sch->isBoolColumn());
        $this->assertEquals(false, $sch->isIntegerColumn());
        $this->assertEquals(false, $sch->isFloatColumn());
        $this->assertEquals(false, $sch->isStringColumn());
    }

    /**
     * @return void
     */
    public function testCastToBool(): void
    {
        $sch = $this->getInitializedColumnSchema('isActive')->castToBoolColumn();
        $this->assertEquals(BoolColumnSchema::class, get_class($sch));
    }

    /**
     * @return void
     */
    public function testCastToInteger(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $sch = $this->getInitializedColumnSchema('isActive')->castToIntegerColumn();
    }

    /**
     * @return void
     */
    public function testCastToString(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $sch = $this->getInitializedColumnSchema('isActive')->castToStringColumn();
    }

    /**
     * @return void
     */
    public function testCastToFloat(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $sch = $this->getInitializedColumnSchema('isActive')->castToFloatColumn();
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
}