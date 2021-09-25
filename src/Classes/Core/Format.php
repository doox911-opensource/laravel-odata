<?php

  namespace Doox911Opensource\LaravelOData\Classes\Core;

  use JetBrains\PhpStorm\Pure;
  use Doox911Opensource\LaravelOData\Traits\Core\ToQuery;
  use Doox911Opensource\LaravelOData\Classes\Enums\QueryOption;
  use Doox911Opensource\LaravelOData\Classes\Enums\ResponseFormat;
  use Doox911Opensource\LaravelOData\Contracts\QueryOptionContract;

  final class Format implements QueryOptionContract
  {
    use ToQuery;

    #[Pure]
    public function __construct(
      private ?ResponseFormat $format = null,
      private ?Grammar $grammar = null
    )
    {
      $this->grammar = $grammar ?? new Grammar;
    }

    /**
     * @return string
     * @see QueryOptionContract::getQueryPrefix
     */
    public function getQueryPrefix(): string
    {
      return '$' . QueryOption::FORMAT();
    }

    /**
     * @return array
     */
    #[Pure]
    public function toArray(): array
    {
      return [
        $this->format
      ];
    }

    #[Pure]
    public function __toString(): string
    {
      return (string)$this->format;
    }
  }
