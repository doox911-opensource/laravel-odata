<?php

  namespace Doox911Opensource\LaravelOData\Classes\Core;

  use JetBrains\PhpStorm\Pure;
  use Doox911Opensource\LaravelOData\Traits\Core\ToQuery;
  use Doox911Opensource\LaravelOData\Classes\Enums\QueryOption;
  use Doox911Opensource\LaravelOData\Contracts\GrammarContract;
  use Doox911Opensource\LaravelOData\Contracts\QueryOptionContract;

  final class Top implements QueryOptionContract
  {

    use ToQuery;

    public const TOP_MAX_QUANTITY = 100;

    private int $quantity;

    private GrammarContract $grammar;

    public function __construct(int $quantity = 0, ?GrammarContract $grammar = null)
    {
      $this->take($quantity);

      $this->grammar = $grammar ?? new Grammar;
    }

    /**
     * @return string
     * @see QueryOptionContract::getQueryPrefix
     */
    public function getQueryPrefix(): string
    {
      return '$' . QueryOption::TOP();
    }

    /**
     * Установить максимальное количество записей по умолчанию
     *
     * @return $this
     */
    public function setDefault(): Top
    {
      $this->quantity = config('laravel-odata.top_max_quantity', self::TOP_MAX_QUANTITY);

      return $this;
    }

    /**
     * Требуемое количество записей
     *
     * @param int $quantity Количество записей
     * @return $this
     */
    public function take(int $quantity): Top
    {
      if ($quantity === 0) {
        $this->quantity = config('laravel-odata.top_max_quantity', self::TOP_MAX_QUANTITY);
      } else if ($quantity < -1) {
        $this->quantity = -1;
      } else {
        $this->quantity = $quantity;
      }

      return $this;
    }

    /**
     * @return array
     */
    #[Pure]
    public function toArray(): array
    {
      return [
        $this->quantity,
      ];
    }

    /**
     * @return string
     */
    #[Pure]
    public function __toString(): string
    {
      return (string)$this->quantity;
    }
  }
