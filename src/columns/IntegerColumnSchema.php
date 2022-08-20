<?php

namespace Mnemesong\TableSchema\columns;

use Webmozart\Assert\Assert;

final class IntegerColumnSchema extends ColumnSchema
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
    public function getDefaultValue(): ?int
    {
        return $this->default;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return 'int';
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
            Assert::true(!isset($minValue) || ($default >= $minValue), "Try to set default "
                . 'value lesser then minimal allowed ' . $minValue);
            Assert::true(!isset($maxValue) || ($default <= $maxValue), "Try to set default "
                . 'value more then maximal allowed ' . $maxValue);
        }
    }

    /**
     * @param ColumnSchema $schema
     * @return IntegerColumnSchema
     */
    static public function assertClass(ColumnSchema $schema): IntegerColumnSchema
    {
        Assert::isAOf($schema, IntegerColumnSchema::class);
        /* @var IntegerColumnSchema $schema */
        return $schema;
    }
}