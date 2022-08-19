<?php

namespace Mnemesong\TableSchemaTestHelpers;

use Mnemesong\TableSchema\columns\ColumnSchema;
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
    abstract public function testTypeChecks(): void;

    /**
     * @return void
     */
    abstract public function testCastToBool(): void;

    /**
     * @return void
     */
    abstract public function testCastToInteger(): void;

    /**
     * @return void
     */
    abstract public function testCastToString(): void;

    /**
     * @return void
     */
    abstract public function testCastToFloat(): void;

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
    public function testSpecificationsLogic(): void
    {
        $col1 = $this->getInitializedColumnSchema('name');
        $this->useTestCase()->assertEquals([], $col1->getSpecs());

        $col2 = $col1->withAddSpec('mysql:json');
        $this->useTestCase()->assertEquals([], $col1->getSpecs());
        $this->useTestCase()->assertEquals(['mysql:json' => null], $col2->getSpecs());

        $col3 = $col2->withAddSpec('mysql:datetime', '+5');
        $this->useTestCase()->assertEquals(['mysql:json' => null], $col2->getSpecs());
        $this->useTestCase()->assertEquals(['mysql:json' => null, 'mysql:datetime' => '+5'], $col3->getSpecs());

        $col4 = $col3->withRemovedSpec('mysql:json');
        $this->useTestCase()->assertEquals(['mysql:json' => null, 'mysql:datetime' => '+5'], $col3->getSpecs());
        $this->useTestCase()->assertEquals(['mysql:datetime' => '+5'], $col4->getSpecs());

        $col5 = $col3->withClearSpecs();
        $this->useTestCase()->assertEquals(['mysql:json' => null, 'mysql:datetime' => '+5'], $col3->getSpecs());
        $this->useTestCase()->assertEquals([], $col5->getSpecs());
    }

    /**
     * @return void
     */
    public function testNullableLogic(): void
    {
        $col1 = $this->getInitializedColumnSchema('customer');
        $this->useTestCase()->assertEquals(true, $col1->isNullable());

        $col2 = $col1->withNullDisabled();
        $this->useTestCase()->assertEquals(true, $col1->isNullable());
        $this->useTestCase()->assertEquals(false, $col2->isNullable());

        $col3 = $col2->withNullAllowed();
        $this->useTestCase()->assertEquals(true, $col3->isNullable());
        $this->useTestCase()->assertEquals(false, $col2->isNullable());
    }

    /**
     * @return void
     */
    public function testUniqueLogic(): void
    {
        $col1 = $this->getInitializedColumnSchema('name');
        $this->useTestCase()->assertEquals(false, $col1->isUnique());

        $col2 = $col1->asUnique();
        $this->useTestCase()->assertEquals(false, $col1->isUnique());
        $this->useTestCase()->assertEquals(true, $col2->isUnique());

        $col3 = $col2->asNotUnique();
        $this->useTestCase()->assertEquals(false, $col3->isUnique());
        $this->useTestCase()->assertEquals(true, $col2->isUnique());
    }
}