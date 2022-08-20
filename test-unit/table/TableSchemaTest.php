<?php

namespace Mnemesong\TableSchemaTestUnit\table;

use Mnemesong\TableSchema\columns\BoolAbstractColumnSchema;
use Mnemesong\TableSchema\columns\IntegerAbstractColumnSchema;
use Mnemesong\TableSchema\columns\StringAbstractColumnSchema;
use Mnemesong\TableSchema\table\TableSchema;
use PHPUnit\Framework\TestCase;

class TableSchemaTest extends TestCase
{
    /**
     * @return void
     */
    public function testBasics(): void
    {
        $t1 = new TableSchema('users');
        $this->assertEquals('users', $t1->getTableName());
    }

    /**
     * @return void
     */
    public function testTableNameException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $t1 = new TableSchema('');
    }

    /**
     * @return void
     */
    public function testPrefix(): void
    {
        $t1 = new TableSchema('users');
        $this->assertEquals('', $t1->getPrefix());

        $t2 = $t1->withPrefix('ape_');
        $this->assertEquals('', $t1->getPrefix());
        $this->assertEquals('ape_', $t2->getPrefix());
    }

    /**
     * @return void
     */
    public function testColumns(): void
    {
        $t1 = new TableSchema('users');
        $this->assertEquals([], $t1->getAllColumns());

        $t2 = $t1->withColumn(new BoolAbstractColumnSchema('active'));
        $this->assertEquals([], $t1->getAllColumns());
        $this->assertEquals([new BoolAbstractColumnSchema('active')], $t2->getAllColumns());

        $t3 = $t2->withColumn((new IntegerAbstractColumnSchema('age'))->withNullDisabled());
        $this->assertEquals(
            [new BoolAbstractColumnSchema('active'), (new IntegerAbstractColumnSchema('age'))->withNullDisabled()],
            $t3->getAllColumns()
        );
        $this->assertEquals([new BoolAbstractColumnSchema('active')], $t2->getAllColumns());

        $t4 = $t3->withoutColumn('active');
        $this->assertEquals(
            [new BoolAbstractColumnSchema('active'), (new IntegerAbstractColumnSchema('age'))->withNullDisabled()],
            $t3->getAllColumns()
        );
        $this->assertEquals(
            [(new IntegerAbstractColumnSchema('age'))->withNullDisabled()],
            $t4->getAllColumns()
        );

        $this->assertEquals(new BoolAbstractColumnSchema('active'), $t3->getColumn('active'));

        $t5 = $t3->withClearColumns();
        $this->assertEquals(
            [new BoolAbstractColumnSchema('active'), (new IntegerAbstractColumnSchema('age'))->withNullDisabled()],
            $t3->getAllColumns()
        );
        $this->assertEquals([], $t5->getAllColumns());

        $t6 = $t3->withColumn((new IntegerAbstractColumnSchema('age'))->withAddSpec('mysql:json')->withValueLimits(0, 256));
        $this->assertEquals(
            [new BoolAbstractColumnSchema('active'), (new IntegerAbstractColumnSchema('age'))->withNullDisabled()],
            $t3->getAllColumns()
        );
        $this->assertEquals([
                new BoolAbstractColumnSchema('active'),
                (new IntegerAbstractColumnSchema('age'))->withAddSpec('mysql:json')->withValueLimits(0, 256)
            ], $t6->getAllColumns());
    }

    /**
     * @return void
     */
    public function testPrimaryKeys(): void
    {
        $t1 = (new TableSchema('users'))
            ->withColumn(new IntegerAbstractColumnSchema('id'))
            ->withColumn(new StringAbstractColumnSchema('account'));
        $this->assertEquals([], $t1->getPrimaryKey());

        $t2 = $t1->withPrimaryKey(['id']);
        $this->assertEquals([], $t1->getPrimaryKey());
        $this->assertEquals(['id'], $t2->getPrimaryKey());

        $t3 = $t2->withPrimaryKey(['id', 'account']);
        $this->assertEquals(['id', 'account'], $t3->getPrimaryKey());
        $this->assertEquals(['id'], $t2->getPrimaryKey());

        $t4 = $t3->withoutPrimaryKey();
        $this->assertEquals(['id', 'account'], $t3->getPrimaryKey());
        $this->assertEquals([], $t4->getPrimaryKey());
    }

    /**
     * @return void
     */
    public function testPrimaryKeyToColumnsInvalidStateException1(): void
    {
        $t1 = (new TableSchema('users'))
            ->withColumn(new IntegerAbstractColumnSchema('id'));
        $this->expectException(\InvalidArgumentException::class);
        $t1 = $t1->withPrimaryKey(['account']);
    }

    /**
     * @return void
     */
    public function testPrimaryKeyToColumnsInvalidStateException2(): void
    {
        $t1 = (new TableSchema('users'))
            ->withColumn(new IntegerAbstractColumnSchema('id'));
        $this->expectException(\InvalidArgumentException::class);
        $t1 = $t1->withPrimaryKey(['id', 'users']);
    }

    /**
     * @return void
     */
    public function testPrimaryKeyToColumnsInvalidStateException3(): void
    {
        $t1 = (new TableSchema('users'))
            ->withColumn(new IntegerAbstractColumnSchema('id'));
        $t1 = $t1->withPrimaryKey(['id']);
        $this->expectException(\InvalidArgumentException::class);
        $t1 = $t1->withoutColumn('id');
    }

    /**
     * @return void
     */
    public function testPrimaryKeyToColumnsInvalidStateException4(): void
    {
        $t1 = (new TableSchema('users'))
            ->withColumn(new IntegerAbstractColumnSchema('id'));
        $t1 = $t1->withPrimaryKey(['id']);
        $this->expectException(\InvalidArgumentException::class);
        $t1 = $t1->withClearColumns();
    }
}