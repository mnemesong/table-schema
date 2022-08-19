<?php

namespace Mnemesong\TableSchema\columns;

use Webmozart\Assert\Assert;

class StringColumnSchema extends ColumnSchema
{
    protected ?int $stringLengthLimit = null;
    protected ?string $defaultValue = null;

    /**
     * @param int|null $limit
     * @return $this
     */
    public function withStringLengthLimit(?int $limit): self
    {
        Assert::true(!isset($limit) || ($limit >= 0), "String length limit should be equals or more then 0");
        $this->assertCorrectness($limit, $this->defaultValue);
        $clone = clone $this;
        $clone->stringLengthLimit = $limit;
        return $clone;
    }

    /**
     * @return $this
     */
    public function withoutStringLengthLimit(): self
    {
        $clone = clone $this;
        $clone->stringLengthLimit = null;
        return $clone;
    }

    /**
     * @param string|null $defaultValue
     * @return $this
     */
    public function withDefaultValue(?string $defaultValue): self
    {
        $this->assertCorrectness($this->stringLengthLimit, $defaultValue);
        $clone = clone $this;
        $clone->defaultValue = $defaultValue;
        return $clone;
    }

    /**
     * @return $this
     */
    public function withoutDefaultValue(): self
    {
        $clone = clone $this;
        $clone->defaultValue = null;
        return $clone;
    }

    /**
     * @return int|null
     */
    public function getStringLengthLimit(): ?int
    {
        return $this->stringLengthLimit;
    }

    /**
     * @return string|null
     */
    public function getDefaultValue(): ?string
    {
        return $this->defaultValue;
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
        return true;
    }

    /**
     * @return bool
     */
    public function isBoolColumn(): bool
    {
        return false;
    }

    /**
     * @return bool
     */
    public function isFloatColumn(): bool
    {
        return false;
    }

    /**
     * @param int|null $strLimit
     * @param string|null $default
     * @return void
     */
    protected function assertCorrectness(?int $strLimit, ?string $default): void
    {
        if(isset($defaultValue) && (isset($strLimit))) {
            Assert::true(
                strlen($defaultValue) <= $this->stringLengthLimit,
                "Default value longer then able by string limit"
            );
        }
    }
}