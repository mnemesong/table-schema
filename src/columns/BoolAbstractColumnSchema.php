<?php

namespace Mnemesong\TableSchema\columns;

use Webmozart\Assert\Assert;

final class BoolAbstractColumnSchema extends AbstractColumnSchema
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
     * @param AbstractColumnSchema $schema
     * @return BoolAbstractColumnSchema
     */
    static public function tryToCastFrom(AbstractColumnSchema $schema): BoolAbstractColumnSchema
    {
        Assert::isAOf($schema, BoolAbstractColumnSchema::class);
        /* @var BoolAbstractColumnSchema $schema */
        return $schema;
    }
}