<?php

namespace Mnemesong\TableSchemaTestUnit;

use Mnemesong\TableSchema\ColumnSchema;
use Mnemesong\TableSchema\TableSchema;
use Mnemesong\TableSchemaStubs\CsDateTimeStub;
use Mnemesong\TableSchemaStubs\CsSqlNotNullStub;
use Mnemesong\TableSchemaStubs\CsSqlNullStub;
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

        $t2 = $t1->withColumn(new ColumnSchema('active'));
        $this->assertEquals([], $t1->getAllColumns());
        $this->assertEquals([new ColumnSchema('active')], $t2->getAllColumns());

        $t3 = $t2->withColumn((new ColumnSchema('age'))->withSetting(new CsSqlNotNullStub()));
        $this->assertEquals(
            [new ColumnSchema('active'), (new ColumnSchema('age'))->withSetting(new CsSqlNotNullStub())],
            $t3->getAllColumns()
        );
        $this->assertEquals([new ColumnSchema('active')], $t2->getAllColumns());

        $t4 = $t3->withoutColumn('active');
        $this->assertEquals(
            [new ColumnSchema('active'), (new ColumnSchema('age'))->withSetting(new CsSqlNotNullStub())],
            $t3->getAllColumns()
        );
        $this->assertEquals(
            [(new ColumnSchema('age'))->withSetting(new CsSqlNotNullStub())],
            $t4->getAllColumns()
        );

        $this->assertEquals(new ColumnSchema('active'), $t3->getColumn('active'));

        $t5 = $t3->withColumnsReset([new ColumnSchema('date')]);
        $this->assertEquals(
            [new ColumnSchema('active'), (new ColumnSchema('age'))->withSetting(new CsSqlNotNullStub())],
            $t3->getAllColumns()
        );
        $this->assertEquals([new ColumnSchema('date')], $t5->getAllColumns());

        $t6 = $t3->withColumn((new ColumnSchema('active'))->withSetting(new CsDateTimeStub()));
        $this->assertEquals(
            [new ColumnSchema('active'), (new ColumnSchema('age'))->withSetting(new CsSqlNotNullStub())],
            $t3->getAllColumns()
        );
        $this->assertEquals(
            [
                (new ColumnSchema('active'))->withSetting(new CsDateTimeStub()),
                (new ColumnSchema('age'))->withSetting(new CsSqlNotNullStub())
            ],
            $t6->getAllColumns()
        );
    }

    /**
     * @return void
     */
    public function testPrimaryKeys(): void
    {
        $t1 = (new TableSchema('users'))
            ->withColumn(new ColumnSchema('id'))
            ->withColumn(new ColumnSchema('account'));
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
            ->withColumn(new ColumnSchema('id'));
        $this->expectException(\InvalidArgumentException::class);
        $t1 = $t1->withPrimaryKey(['account']);
    }

    /**
     * @return void
     */
    public function testPrimaryKeyToColumnsInvalidStateException2(): void
    {
        $t1 = (new TableSchema('users'))
            ->withColumn(new ColumnSchema('id'));
        $this->expectException(\InvalidArgumentException::class);
        $t1 = $t1->withPrimaryKey(['id', 'users']);
    }

    /**
     * @return void
     */
    public function testPrimaryKeyToColumnsInvalidStateException3(): void
    {
        $t1 = (new TableSchema('users'))
            ->withColumn(new ColumnSchema('id'));
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
            ->withColumn(new ColumnSchema('id'));
        $t1 = $t1->withPrimaryKey(['id']);
        $this->expectException(\InvalidArgumentException::class);
        $t1 = $t1->withColumnsReset([]);
    }
}