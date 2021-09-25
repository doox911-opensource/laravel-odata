<?php

  namespace Doox911Opensource\LaravelOData\Classes\Core;

  use Closure;
  use JetBrains\PhpStorm\Pure;
  use Doox911Opensource\ValueObjects\Exceptions\ValueObjectsException;
  use Doox911Opensource\LaravelOData\Contracts\ODataCollectionContract;

  class Slice
  {

    private Filter $condition;

    public function __construct(
      private string $type,
      private ?string $period = null,
      private ?Grammar $grammar = null,
    )
    {
      if ($period !== null) {
        $this->setPeriod($period);
      }

      if (!$grammar) {
        $this->grammar = new Grammar();
      }

      $this->condition = new Filter;
    }

    /**
     * Добавить условие
     *
     * @throws ValueObjectsException
     */
    public function addCondition(string $field, string $operator, string $value)
    {
      $this->condition->add($field, $operator, $value);
    }

    /**
     * Добавить условие (или)
     *
     * @throws ValueObjectsException
     */
    public function orAddCondition(string $field, string $operator, string $value)
    {
      $this->condition->orAdd($field, $operator, $value);
    }

    /**
     * Область
     *
     * @param Closure $callable Замыкание
     * @return $this
     */
    public function scope(Closure $callable): Slice
    {
      $this->condition->scope($callable);

      return $this;
    }

    /**
     * Область (или)
     *
     * @param Closure $callable Замыкание
     * @return $this
     */
    public function orScope(Closure $callable): Slice
    {
      $this->condition->orScope($callable);

      return $this;
    }

    /**
     * Период
     *
     * @return string|null
     */
    public function getPeriod(): ?string
    {
      return $this->period;
    }

    /**
     * Установить период
     *
     * @param string $period
     */
    public function setPeriod(string $period)
    {
      $this->period = $period;
    }

    /**
     * @return string
     */
    public function toQuery(): string
    {
      return $this
        ->grammar
        ->encode((string)$this);
    }

    /**
     * @return ODataCollectionContract
     */
    #[Pure]
    public function getConditions(): ODataCollectionContract
    {
      return $this->condition->filters();
    }

    /**
     * @return string
     */
    public function __toString()
    {
      $string = '/' . $this->type . '(';

      if ($this->period) {
        $string .= '(Period=' . $this->period;
      }

      if ($this->condition->filters()->length()) {
        if ($this->period) {
          $string .= ',';
        }

        $string .= 'Condition=' . $this->condition . ')';
      }

      $string .= ')';

      return $string;
    }
  }
