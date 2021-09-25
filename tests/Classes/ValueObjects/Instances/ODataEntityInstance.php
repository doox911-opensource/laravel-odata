<?php

  namespace Doox911Opensource\LaravelOData\Tests\Classes\ValueObjects\Instances;

  use Doox911Opensource\ValueObjects\Exceptions\ValueObjectsException;
  use Doox911Opensource\LaravelOData\Classes\ValueObjects\ODataEntity;

  final class ODataEntityInstance
  {

    /**
     * @throws ValueObjectsException
     */
    public static function new(string $value): ODataEntity
    {
      return new ODataEntity([
        'value' => $value,
      ]);
    }

  }
