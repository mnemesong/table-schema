<?php

namespace Mnemesong\TableSchemaTestUnit\helpers;

use Mnemesong\TableSchema\columns\BoolAbstractColumnSchema;
use Mnemesong\TableSchema\columns\AbstractColumnSchema;
use Mnemesong\TableSchema\columns\FloatAbstractColumnSchema;
use Mnemesong\TableSchema\columns\IntegerAbstractColumnSchema;
use Mnemesong\TableSchema\columns\StringAbstractColumnSchema;
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
            BoolAbstractColumnSchema::class,
            FloatAbstractColumnSchema::class,
            IntegerAbstractColumnSchema::class,
            StringAbstractColumnSchema::class,
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
            Assert::isAOf($col, AbstractColumnSchema::class);
            /* @var AbstractColumnSchema $col */
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