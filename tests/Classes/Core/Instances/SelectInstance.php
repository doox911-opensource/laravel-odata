<?php

  namespace Doox911Opensource\LaravelOData\Tests\Classes\Core\Instances;

  use Doox911Opensource\LaravelOData\Classes\Core\Select;
  use Doox911Opensource\ValueObjects\Exceptions\ValueObjectsException;

  final class SelectInstance
  {

    public static function new(): Select
    {
      return new Select;
    }

    /**
     * @throws ValueObjectsException
     */
    public static function addSelect(string $select): Select
    {
      $instance = self::new();

      $instance->add($select);

      return $instance;
    }

    /**
     * @throws ValueObjectsException
     */
    public static function addSelects(array $selects): Select
    {
      $instance = self::new();

      foreach ($selects as $select) {
        $instance->add($select);
      }

      return $instance;
    }
  }
