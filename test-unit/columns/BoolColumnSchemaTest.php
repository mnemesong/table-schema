<?php

namespace Mnemesong\TableSchemaTestUnit\columns;

use Mnemesong\TableSchema\columns\BoolAbstractColumnSchema;
use Mnemesong\TableSchema\columns\AbstractColumnSchema;
use Mnemesong\TableSchema\columns\StringAbstractColumnSchema;
use Mnemesong\TableSchemaStubs\AbstractColumnSchemaStub;
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
     * @return AbstractColumnSchema
     */
    protected function getInitializedColumnSchema(string $name): AbstractColumnSchema
    {
        return new BoolAbstractColumnSchema($name);
    }

    /**
     * @return void
     */
    public function testDefault(): void
    {
        $col1 = new BoolAbstractColumnSchema('updated');
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
        $col = BoolAbstractColumnSchema::tryToCastFrom($col);
        $this->assertTrue(is_a($col, BoolAbstractColumnSchema::class));
    }

    /**
     * @return void
     */
    public function testTryToCastException(): void
    {
        $col = new StringAbstractColumnSchema('name');
        $this->expectException(\InvalidArgumentException::class);
        $col = BoolAbstractColumnSchema::tryToCastFrom($col);
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