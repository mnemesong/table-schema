<?php

namespace Mnemesong\TableSchema\columns;

use Webmozart\Assert\Assert;

class FloatColumnSchema extends ColumnSchema
{
    protected ?float $minValue = null;
    protected ?float $maxValue = null;
    protected float $accuracy = 0.0001;
    protected ?float $default = null;

    /**
     * @param float|null $minValue
     * @param float|null $maxValue
     * @return $this
     */
    public function withValueLimits(?float $minValue, ?float $maxValue): self
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
     * @param float $allowedAccuracy
     * @return $this
     */
    public function withAccuracy(float $allowedAccuracy): self
    {
        Assert::true($allowedAccuracy > 0, 'Accuracy should be number more then 0');
        $clone = clone $this;
        $clone->accuracy = $allowedAccuracy;
        return $clone;
    }

    /**
     * @param float|null $default
     * @return $this
     */
    public function withDefaultValue(?float $default): self
    {
        $this->assertValuesCorrect($this->minValue, $this->maxValue, $default);
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
     * @return float|null
     */
    public function getMinValue(): ?float
    {
        return $this->minValue;
    }

    /**
     * @return float|null
     */
    public function getMaxValue(): ?float
    {
        return $this->maxValue;
    }

    /**
     * @return float
     */
    public function getAccuracy(): float
    {
        return $this->accuracy;
    }

    /**
     * @return int|null
     */
    public function getDefaultValue(): ?float
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
        return false;
    }

    /**
     * @return bool
     */
    public function isFloatColumn(): bool
    {
        return true;
    }

    /**
     * @param float|null $minValue
     * @param float|null $maxValue
     * @param float|null $default
     * @return void
     */
    protected function assertValuesCorrect(?float $minValue, ?float $maxValue, ?float $default): void
    {
        if(isset($default)) {
            Assert::true(!isset($minValue) || ($default >= $minValue), "Try to set default "
                . 'value lesser then minimal allowed ' . $minValue);
            Assert::true(!isset($maxValue) || ($default <= $maxValue), "Try to set default "
                . 'value more then maximal allowed ' . $maxValue);
        }
    }

}