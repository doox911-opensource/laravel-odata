<?php

  namespace Doox911Opensource\LaravelOData\Classes\Core;

  use JetBrains\PhpStorm\Pure;
  use Doox911Opensource\LaravelOData\Traits\Core\ToQuery;
  use Doox911Opensource\LaravelOData\Classes\Enums\QueryOption;
  use Doox911Opensource\LaravelOData\Contracts\GrammarContract;
  use Doox911Opensource\LaravelOData\Contracts\QueryOptionContract;

  final class Skip implements QueryOptionContract
  {

    use ToQuery;

    private int $quantity;

    private GrammarContract $grammar;

    public function __construct(int $quantity = 0, ?GrammarContract $grammar = null)
    {
      $this->skip($quantity);

      $this->grammar = $grammar ?? new Grammar;
    }

    /**
     * @return string
     * @see QueryOptionContract::getQueryPrefix
     */
    public function getQueryPrefix(): string
    {
      return '$' . QueryOption::SKIP();
    }

    /**
     * Поропускаемое количество записей
     *
     * @param int $quantity Количество записей
     * @return $this
     */
    public function skip(int $quantity): Skip
    {
      if ($quantity < 0) {
        $this->quantity = 0;
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
