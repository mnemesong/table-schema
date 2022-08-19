<?php

namespace Mnemesong\TableSchema\columns;

use Webmozart\Assert\Assert;

abstract class ColumnSchema
{

    protected string $columnName;
    protected bool $nullable = true;
    /* @phpstan-ignore-next-line */
    protected array $specs = [];
    protected bool $unique = false;

    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->setColumnName($name);
    }

    /**
     * @param string $columnName
     * @return void
     */
    protected function setColumnName(string $columnName): void
    {
        Assert::true(strlen($columnName) > 0, 'Column Name string should be not empty');
        $this->columnName = $columnName;
    }

    /**
     * @return $this
     */
    public function withNullAllowed(): self
    {
        $clone = clone $this;
        $clone->nullable = true;
        return $clone;
    }

    /**
     * @return $this
     */
    public function withNullDisabled(): self
    {
        $clone = clone $this;
        $clone->nullable = false;
        return $clone;
    }

    /**
     * @param string $key
     * @param scalar|null $value
     * @return $this
     */
    public function withAddSpec(string $key, $value = null): self
    {
        Assert::true(strlen($key) > 0, 'String length of column specification key should be more then 0');
        Assert::nullOrScalar($value, "Column specification value should be null or scalar");
        $clone = clone $this;
        $clone->specs[$key] = $value;
        return $clone;
    }

    /**
     * @param string $key
     * @return $this
     */
    public function withRemovedSpec(string $key): self
    {
        Assert::keyExists($this->specs, $key, "Specification key " . $key . " is not exist");
        $clone = clone $this;
        $clone->specs = array_filter($clone->specs, fn(string $specKey) => ($specKey !== $key), ARRAY_FILTER_USE_KEY);
        return $clone;
    }

    /**
     * @return $this
     */
    public function withClearSpecs(): self
    {
        $clone = clone $this;
        $clone->specs = [];
        return $clone;
    }

    /**
     * @return $this
     */
    public function asUnique(): self
    {
        $clone = clone $this;
        $clone->unique = true;
        return $clone;
    }

    /**
     * @return $this
     */
    public function asNotUnique(): self
    {
        $clone = clone $this;
        $clone->unique = false;
        return $clone;
    }

    /**
     * @return string
     */
    public function getColumnName(): string
    {
        return $this->columnName;
    }

    /**
     * @return bool
     */
    public function isNullable(): bool
    {
        return $this->nullable;
    }

    /**
     * @return scalar[]
     */
    public function getSpecs(): array
    {
        return $this->specs;
    }

    /**
     * @return bool
     */
    public function isUnique(): bool
    {
        return $this->unique;
    }

    /**
     * @return bool
     */
    abstract public function isIntegerColumn(): bool;

    /**
     * @return bool
     */
    abstract public function isStringColumn(): bool;

    /**
     * @return bool
     */
    abstract public function isBoolColumn(): bool;

    /**
     * @return bool
     */
    abstract public function isFloatColumn(): bool;

    /**
     * @return IntegerColumnSchema
     */
    public function castToIntegerColumn(): IntegerColumnSchema
    {
        Assert::isAOf($this, IntegerColumnSchema::class, 'Try to cast not integer column schema as integer');
        /* @var IntegerColumnSchema $this */
        return $this;
    }

    /**
     * @return FloatColumnSchema
     */
    public function castToFloatColumn(): FloatColumnSchema
    {
        Assert::isAOf($this, FloatColumnSchema::class, 'Try to cast not float column schema as float');
        /* @var FloatColumnSchema $this */
        return $this;
    }

    /**
     * @return StringColumnSchema
     */
    public function castToStringColumn(): StringColumnSchema
    {
        Assert::isAOf($this, StringColumnSchema::class, 'Try to cast not string column schema as string');
        /* @var StringColumnSchema $this */
        return $this;
    }

    /**
     * @return BoolColumnSchema
     */
    public function castToBoolColumn(): BoolColumnSchema
    {
        Assert::isAOf($this, BoolColumnSchema::class, 'Try to cast not bool column schema as bool');
        /* @var BoolColumnSchema $this */
        return $this;
    }
}