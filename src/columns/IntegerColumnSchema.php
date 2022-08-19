<?php

namespace Mnemesong\TableSchema\columns;

use Webmozart\Assert\Assert;

class IntegerColumnSchema extends ColumnSchema
{
    protected ?int $maxValue = null;
    protected ?int $minValue = null;
    protected ?int $default = null;

    /**
     * @param int|null $minValue
     * @param int|null $maxValue
     * @return $this
     */
    public function withValueLimits(?int $minValue, ?int $maxValue): self
    {
        if(isset($minValue) && isset($maxValue) && ($maxValue < $minValue)) {
            $tmp = $minValue;
            $minValue = $maxValue;
            $maxValue = $tmp;
            unset($tmp);
        }
        $this->assertValuesCorrect($minValue, $maxValue, $this->default);
        $clone = clone $this;
        $clone->minValue = $minValue;
        $clone->maxValue = $maxValue;
        return $clone;
    }

    /**
     * @return $this
     */
    public function withoutValueLimits(): self
    {
        $clone = clone $this;
        $clone->minValue = null;
        $clone->maxValue = null;
        return $clone;
    }

    /**
     * @param int|null $default
     * @return $this
     */
    public function withDefaultValue(?int $default): self
    {
        $this->assertValuesCorrect($this->minValue, $this->maxValue, $this->default);
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
     * @return int|null
     */
    public function getMaxValue(): ?int
    {
        return $this->maxValue;
    }

    /**
     * @return int|null
     */
    public function getMinValue(): ?int
    {
        return $this->minValue;
    }

    /**
     * @return int|null
     */
    public function getDefault(): ?int
    {
        return $this->default;
    }

    /**
     * @return bool
     */
    public function isIntegerColumn(): bool
    {
        return true;
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
     * @param int|null $minValue
     * @param int|null $maxValue
     * @param int|null $default
     * @return void
     */
    protected function assertValuesCorrect(?int $minValue, ?int $maxValue, ?int $default): void
    {
        if(isset($default)) {
            Assert::true(isset($minValue) || ($default >= $minValue), "Try to set default "
                . 'value lesser then minimal allowed ' . $minValue);
            Assert::true(isset($minValue) || ($default >= $minValue), "Try to set default "
                . 'value more then maximal allowed ' . $maxValue);
        }
    }
}