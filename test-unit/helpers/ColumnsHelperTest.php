<?php

namespace Mnemesong\TableSchemaTestUnit\helpers;

use Mnemesong\TableSchema\columns\BoolColumnSchema;
use Mnemesong\TableSchema\columns\ColumnSchema;
use Mnemesong\TableSchema\columns\FloatColumnSchema;
use Mnemesong\TableSchema\columns\IntegerColumnSchema;
use Mnemesong\TableSchema\columns\StringColumnSchema;
use Mnemesong\TableSchema\helpers\ColumnsHelper;
use PHPUnit\Framework\TestCase;
use Webmozart\Assert\Assert;

class ColumnsHelperTest extends TestCase
{
    /**
     * @return void
     */
    public function testAdequacy(): void
    {
        $this->assertEmpty(array_diff(ColumnsHelper::typesAssociation(), [
            BoolColumnSchema::class,
            FloatColumnSchema::class,
            IntegerColumnSchema::class,
            StringColumnSchema::class,
        ]));
    }

    /**
     * @return void
     */
    public function testCorrectness(): void
    {
        foreach (ColumnsHelper::typesAssociation() as $type => $class)
        {
            $col = new $class('someName');
            Assert::isAOf($col, ColumnSchema::class);
            /* @var ColumnSchema $col */
            $this->assertEquals($col->getType(), $type);
        }
    }

    /**
     * @return void
     */
    public function testUnique(): void
    {
        $classes = array_values(ColumnsHelper::typesAssociation());
        $this->assertEquals($classes, array_unique($classes));

        $types = array_keys(ColumnsHelper::typesAssociation());
        $this->assertEquals($types, array_unique($types));
    }

    /**
     * @return void
     * @throws \ErrorException
     */
    public function testGetters(): void
    {
        foreach (ColumnsHelper::typesAssociation() as $type => $class) {
            $this->assertEquals(ColumnsHelper::classByType($type), $class);
            $this->assertEquals(ColumnsHelper::typeByClass($class), $type);
        }
    }
}