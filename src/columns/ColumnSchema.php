<?php

namespace Mnemesong\TableSchema\columns;

use Webmozart\Assert\Assert;

abstract class ColumnSchema
{
    protected string $name;
    protected bool $nullable = true;

    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->setName($name);
    }

    /**
     * @param string $name
     * @return void
     */
    protected function setName(string $name): void
    {
        Assert::true(strlen($name) > 0, 'Column Name string should be not empty');
        $this->name = $name;
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

    /**
     * @return IntegerColumnSchema
     */
    public function convertToIntegerColumn(): IntegerColumnSchema
    {
        return new IntegerColumnSchema($this->name);
    }


    /**
     * @return FloatColumnSchema
     */
    public function convertToFloatColumn(): FloatColumnSchema
    {
        return new FloatColumnSchema($this->name);
    }

    /**
     * @return StringColumnSchema
     */
    public function convertToStringColumn(): StringColumnSchema
    {
        return new StringColumnSchema($this->name);
    }

    /**
     * @return BoolColumnSchema
     */
    public function convertToBoolColumn(): BoolColumnSchema
    {
        return new BoolColumnSchema($this->name);
    }
}