<?php

  namespace Doox911Opensource\LaravelOData\Classes\Core;

  use function strlen;
  use function is_string;
  use JetBrains\PhpStorm\Pure;
  use Doox911Opensource\LaravelOData\Contracts\GrammarContract;
  use Doox911Opensource\LaravelOData\Contracts\QueryOptionContract;

  class Finder implements QueryOptionContract
  {

    #[Pure]
    public function __construct(
      private int|string $identifier = '',
      private ?GrammarContract $grammar = null
    )
    {
      $this->grammar = $grammar ?? new Grammar;
    }

    /**
     * Установить идентификатор сущности
     *
     * @param int|string $identifier Идентификатор сущности
     * @return $this
     */
    public function setId(int|string $identifier): Finder
    {
      $this->identifier = $identifier;

      return $this;
    }

    /**
     * @return array
     */
    #[Pure]
    public function toArray(): array
    {
      return [
        $this->identifier,
      ];
    }

    /**
     * @return string
     * @see QueryOptionContract::toQuery
     */
    public function toQuery(): string
    {
      return $this
        ->grammar
        ->encode((string)$this);
    }

    #[Pure]
    public function __toString(): string
    {
      $identifier = '';

      if (is_string($this->identifier) && strlen($this->identifier)) {
        $identifier = '(' . $this->identifier . ')';
      }

      return $identifier;
    }
  }
