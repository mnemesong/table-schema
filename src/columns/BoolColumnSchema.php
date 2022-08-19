<?php

namespace Mnemesong\TableSchema\columns;

class BoolColumnSchema extends ColumnSchema
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
     * @return bool
     */
    public function isIntegerColumn(): bool
    {
        return false;
    }

    /**
     * @return bool
     */
    public function isStringColumn(): bool
    {
        return false;
    }

    /**
     * @return bool
     */
    public function isBoolColumn(): bool
    {
        return true;
    }

    /**
     * @return bool
     */
    public function isFloatColumn(): bool
    {
        return false;
    }
}