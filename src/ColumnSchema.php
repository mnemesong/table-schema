<?php

namespace Mnemesong\TableSchema;

use Webmozart\Assert\Assert;

class ColumnSchema
{
    protected string $columnName;
    /* @phpstan-ignore-next-line */
    protected array $settings = [];

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
     * @param ColumnSettingInterface $spec
     * @return $this
     */
    public function withSetting(ColumnSettingInterface $spec): self
    {
        Assert::isEmpty(array_intersect($spec->getIncompatibleKeys(), $this->getAllSettingKeys()));
        $clone = clone $this;
        $clone->settings[] = $spec;
        return $clone;
    }

    /**
     * @param array $settings
     * @return $this
     */
    public function withSettingsReset(array $settings): self
    {
        Assert::allIsAOf($settings, ColumnSettingInterface::class);
        $clone = clone $this;
        $clone->settings = $settings;
        return $clone;
    }

    /**
     * @param string $key
     * @return $this
     */
    public function withoutSetting(string $key): self
    {
        Assert::inArray($key, $this->getAllSettingKeys());
        $clone = clone $this;
        $clone->settings = array_filter($clone->settings, fn(ColumnSettingInterface $set) => ($set->getKey() !== $key));
        $clone->settings = array_values($clone->settings);
        return $clone;
    }

    /**
     * @return string[]
     */
    public function getAllSettingKeys(): array
    {
        return array_map(fn(ColumnSettingInterface $spec) => ($spec->getKey()), $this->settings);
    }

    /**
     * @return string
     */
    public function getColumnName(): string
    {
        return $this->columnName;
    }

    /**
     * @return ColumnSettingInterface[]
     */
    public function getAllSpecs(): array
    {
        return $this->settings;
    }

}