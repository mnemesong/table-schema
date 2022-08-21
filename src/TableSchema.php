<?php

namespace Mnemesong\TableSchema;

use Webmozart\Assert\Assert;

class TableSchema
{
    protected string $tableName;
    protected string $prefix = '';
    /* @phpstan-ignore-next-line */
    protected array $columns = [];
    /* @phpstan-ignore-next-line */
    protected array $pk = [];

    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->setName($name);
    }

    /**
     * @return string
     */
    public function getTableName(): string
    {
        return $this->tableName;
    }

    /**
     * @param string $prefix
     * @return $this
     */
    public function withPrefix(string $prefix): self
    {
        $clone = clone $this;
        $clone->prefix = $prefix;
        return $clone;
    }

    /**
     * @return string
     */
    public function getPrefix(): string
    {
        return $this->prefix;
    }

    /**
     * @param ColumnSchema $columnSchema
     * @return $this
     */
    public function withColumn(ColumnSchema $columnSchema): self
    {
        $clone = clone $this;
        foreach ($clone->columns as &$c)
        {
            /* @var ColumnSchema $c */
            if($columnSchema->getColumnName() === $c->getColumnName()) {
                $c = $columnSchema;
                return $clone;
            }
        }
        $clone->columns[] = $columnSchema;
        return $clone;
    }

    /**
     * @param string $columnName
     * @return $this
     */
    public function withoutColumn(string $columnName): self
    {
        $newColumns = array_filter($this->columns, fn(ColumnSchema $c) => ($c->getColumnName() !== $columnName));
        $newColumns = array_values($newColumns);
        $this->assertColumnsPkValid($this->pk, $newColumns);
        $clone = clone $this;
        $clone->columns = $newColumns;
        return $clone;
    }

    /**
     * @param string $columnName
     * @return ColumnSchema|null
     */
    public function getColumn(string $columnName): ?ColumnSchema
    {
        $col = array_filter($this->columns, fn(ColumnSchema $c) => ($c->getColumnName() === $columnName));
        if(empty($col)) {
            return null;
        }
        return $col[\array_key_first($col)];
    }

    /**
     * @return ColumnSchema[]
     */
    public function getAllColumns(): array
    {
        return $this->columns;
    }

    /**
     * @return $this
     */
    public function withColumnsReset(array $columns): self
    {
        Assert::allIsAOf($columns, ColumnSchema::class);
        $this->assertColumnsPkValid($this->pk, $columns);
        $clone = clone $this;
        $clone->columns = $columns;
        return $clone;
    }

    /**
     * @param string[] $pkColumns
     * @return $this
     */
    public function withPrimaryKey(array $pkColumns): self
    {
        Assert::allStringNotEmpty($pkColumns, "Set Primary keys parameter should be array of not empty strings");
        $this->assertColumnsPkValid($pkColumns, $this->columns);
        $clone = clone $this;
        $clone->pk = $pkColumns;
        return $clone;
    }

    /**
     * @return $this
     */
    public function withoutPrimaryKey(): self
    {
        $clone = clone $this;
        $clone->pk = [];
        return $clone;
    }

    /**
     * @return string[]
     */
    public function getPrimaryKey(): array
    {
        return $this->pk;
    }

    /**
     * @param string $name
     * @return void
     */
    protected function setName(string $name): void
    {
        Assert::stringNotEmpty($name, "Table name should be not empty string");
        $this->tableName = $name;
    }

    /**
     * @param string[] $pkColumns
     * @param ColumnSchema[] $columns
     * @return void
     */
    protected function assertColumnsPkValid(array $pkColumns, array $columns): void
    {
        $columnNames = array_map(fn(ColumnSchema $c) => ($c->getColumnName()), $columns);
        Assert::isEmpty(array_diff($pkColumns, $columnNames), "Try to set Primary Key to not exists value");
    }
}