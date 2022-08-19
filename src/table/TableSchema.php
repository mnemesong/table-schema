<?php

namespace Mnemesong\TableSchema\table;

use Mnemesong\TableSchema\columns\ColumnSchema;
use Webmozart\Assert\Assert;

class TableSchema
{
    protected string $tableName;
    protected string $prefix = '';
    protected array $columns = [];
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
     * @return $this
     */
    public function withoutPrefix(): self
    {
        $clone = clone $this;
        $clone->prefix = '';
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
        $clone->columns = array_filter($clone->columns, fn(ColumnSchema $c) => ($c !== $columnSchema->getColumnName()));
        $clone->columns[] = $columnSchema;
        return $clone;
    }

    /**
     * @param string $columnName
     * @return $this
     */
    public function withoutColumn(string $columnName): self
    {
        $clone = clone $this;
        $clone->columns = array_filter($clone->columns, fn(ColumnSchema $c) => ($c !== $columnName));
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
        return $col[array_key_first($col)];
    }

    /**
     * @return array
     */
    public function getAllColumns(): array
    {
        return $this->columns;
    }

    /**
     * @return $this
     */
    public function withClearColumns(): self
    {
        $clone = clone $this;
        $clone->columns = [];
        return $clone;
    }

    /**
     * @param array $pkColumns
     * @return $this
     */
    public function withPrimaryKey(array $pkColumns): self
    {
        Assert::allStringNotEmpty($pkColumns, "Set Primary keys parameter should be array of not empty strings");
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
     * @return array
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
}