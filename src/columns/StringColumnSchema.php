<?php

namespace Mnemesong\TableSchema\columns;

use Webmozart\Assert\Assert;

final class StringColumnSchema extends ColumnSchema
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
     * @return string
     */
    public function getType(): string
    {
        return 'string';
    }

    /**
     * @param int|null $strLimit
     * @param string|null $default
     * @return void
     */
    protected function assertCorrectness(?int $strLimit, ?string $default): void
    {
        if(isset($default) && (isset($strLimit))) {
            Assert::true(
                strlen($default) <= $this->stringLengthLimit,
                "Default value longer then able by string limit"
            );
        }
    }

    /**
     * @param ColumnSchema $schema
     * @return StringColumnSchema
     */
    static public function assertClass(ColumnSchema $schema): StringColumnSchema
    {
        Assert::isAOf($schema, StringColumnSchema::class);
        /* @var StringColumnSchema $schema */
        return $schema;
    }
}