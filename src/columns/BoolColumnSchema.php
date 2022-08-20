<?php

namespace Mnemesong\TableSchema\columns;

use Webmozart\Assert\Assert;

final class BoolColumnSchema extends ColumnSchema
{
    protected ?bool $default = null;

    /**
     * @param bool|null $default
     * @return $this
     */
    public function withDefaultValue(?bool $default): self
    {
        $clone = clone $this;
        $clone->default = $default;
        return $clone;
    }

    /**
     * @return $this
     */
    public function withoutDefaultValue(): self
    {
        $clone = clone $this;
        $clone->default = null;
        return $clone;
    }

    /**
     * @return bool|null
     */
    public function getDefaultValue(): ?bool
    {
        return $this->default;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return 'bool';
    }

    /**
     * @param ColumnSchema $schema
     * @return BoolColumnSchema
     */
    static public function tryToCastFrom(ColumnSchema $schema): BoolColumnSchema
    {
        Assert::isAOf($schema, BoolColumnSchema::class);
        /* @var BoolColumnSchema $schema */
        return $schema;
    }
}