<?php

  namespace Doox911Opensource\LaravelOData\Traits;

  use function is_a;
  use Doox911Opensource\LaravelOData\Exceptions\LaravelODataException;

  trait AssertIsA
  {

    /**
     * @throws LaravelODataException
     */
    protected function assertIsA(mixed $value, string $type)
    {
      if (!is_a($value, $type)) {
        throw new LaravelODataException("Items must be instances of $type");
      }
    }
  }
