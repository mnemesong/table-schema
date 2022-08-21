<?php

namespace Mnemesong\TableSchemaTestHelpers;

use Mnemesong\TableSchema\ColumnSchema;
use Mnemesong\TableSchemaStubs\CsDateTimeStub;
use Mnemesong\TableSchemaStubs\CsSqlNotNullStub;
use PHPUnit\Framework\TestCase;

trait ColumnSchemaTestTrait
{
    /**
     * @return TestCase
     */
    abstract protected function useTestCase(): TestCase;

    /**
     * @param string $name
     * @return ColumnSchema
     */
    abstract protected function getInitializedColumnSchema(string $name): ColumnSchema;

    /**
     * @return void
     */
    public function testColumnSchemaBasics(): void
    {
        $col1 = $this->getInitializedColumnSchema('age');
        $this->useTestCase()->assertEquals('age', $col1->getColumnName());
    }

    /**
     * @return void
     */
    public function testConstructionException(): void
    {
        $this->useTestCase()->expectException(\InvalidArgumentException::class);
        $col1 = $this->getInitializedColumnSchema('');
    }

    /**
     * @return void
     */
    public function testSettingsLogic(): void
    {
        $col1 = $this->getInitializedColumnSchema('name');
        $this->useTestCase()->assertEquals([], $col1->getAllSettings());

        $col2 = $col1->withSetting(new CsDateTimeStub());
        $this->useTestCase()->assertEquals([], $col1->getAllSettings());
        $this->useTestCase()->assertEquals([new CsDateTimeStub()], $col2->getAllSettings());

        $col3 = $col2->withSetting(new CsSqlNotNullStub());
        $this->useTestCase()->assertEquals([new CsDateTimeStub()], $col2->getAllSettings());
        $this->useTestCase()->assertEquals([new CsDateTimeStub(), new CsSqlNotNullStub()], $col3->getAllSettings());

        $col4 = $col3->withoutSetting((new CsDateTimeStub())->getKey());
        $this->useTestCase()->assertEquals([new CsDateTimeStub(), new CsSqlNotNullStub()], $col3->getAllSettings());
        $this->useTestCase()->assertEquals([new CsSqlNotNullStub()], $col4->getAllSettings());

        $col5 = $col4->withSettingsReset([(new CsDateTimeStub())]);
        $this->useTestCase()->assertEquals([new CsSqlNotNullStub()], $col4->getAllSettings());
        $this->useTestCase()->assertEquals([(new CsDateTimeStub())], $col5->getAllSettings());

        $this->useTestCase()->assertEquals([
            (new CsDateTimeStub())->getKey(),
            (new CsSqlNotNullStub())->getKey(),
        ], $col3->getAllSettingKeys());
    }


}