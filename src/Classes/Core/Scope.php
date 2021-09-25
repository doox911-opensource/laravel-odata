<?php

  namespace Doox911Opensource\LaravelOData\Classes\Core;

  use Doox911Opensource\LaravelOData\Classes\Enums\LogicalOperator;

  final class Scope
  {

    /**
     * Ключи элементов в области
     */
    private array $keys;

    /**
     * Оператор соединения
     */
    private LogicalOperator $operator;

    private null|int|string $parent_key;

    public function __construct(
      LogicalOperator $operator,
      int|string $key = null,
      null|int|string $parent_key = null
    )
    {
      $this->keys = [];

      $this->operator = $operator;

      $this->parent_key = $parent_key;

      if ($key) {
        $this->addKey($key);
      }
    }

    public function getKeys(): array
    {
      return $this->keys;
    }

    public function getOperator(): string
    {
      return (string)$this->operator;
    }

    public function getParentKey(): null|int|string
    {
      return $this->parent_key;
    }

    /**
     * @param int|string|null $scope_key Ключ области
     * @return Scope
     */
    public function setParentKey(null|int|string $scope_key): Scope
    {
      $this->parent_key = $scope_key;

      return $this;
    }

    public function addKey($key): Scope
    {
      $this->keys[] = $key;

      return $this;
    }
  }
