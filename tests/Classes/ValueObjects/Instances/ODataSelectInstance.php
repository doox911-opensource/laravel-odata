<?php

  namespace Doox911Opensource\LaravelOData\Tests\Classes\ValueObjects\Instances;

  use Doox911Opensource\ValueObjects\Exceptions\ValueObjectsException;
  use Doox911Opensource\LaravelOData\Classes\ValueObjects\ODataSelect;

  final class ODataSelectInstance
  {

    /**
     * @throws ValueObjectsException
     */
    public static function new(string $value): ODataSelect
    {
      return new ODataSelect([
        'value' => $value,
      ]);
    }

  }
