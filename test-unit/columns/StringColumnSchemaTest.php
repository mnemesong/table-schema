<?php

namespace Mnemesong\TableSchemaTestUnit\columns;

use Mnemesong\TableSchema\columns\AbstractColumnSchema;
use Mnemesong\TableSchema\columns\IntegerAbstractColumnSchema;
use Mnemesong\TableSchema\columns\StringAbstractColumnSchema;
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
     * @return AbstractColumnSchema
     */
    protected function getInitializedColumnSchema(string $name): AbstractColumnSchema
    {
        return new StringAbstractColumnSchema($name);
    }

    /**
     * @return void
     */
    public function testLengthLimit(): void
    {
        $col1 = new StringAbstractColumnSchema('date');
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
        (new StringAbstractColumnSchema('date'))->withStringLengthLimit(-1);
    }

    /**
     * @return void
     */
    public function testDefaultValue(): void
    {
        $col1 = new StringAbstractColumnSchema('name');
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

    /**
     * @return void
     */
    public function testTryToCast(): void
    {
        $col = $this->getInitializedColumnSchema('name');
        $col = StringAbstractColumnSchema::tryToCastFrom($col);
        $this->assertTrue(is_a($col, StringAbstractColumnSchema::class));
    }

    /**
     * @return void
     */
    public function testTryToCastException(): void
    {
        $col = new IntegerAbstractColumnSchema('score');
        $this->expectException(\InvalidArgumentException::class);
        $col = StringAbstractColumnSchema::tryToCastFrom($col);
    }

    /**
     * @return void
     */
    public function testGetType(): void
    {
        $col = $this->getInitializedColumnSchema('date');
        $this->assertEquals('string', $col->getType());
    }
}