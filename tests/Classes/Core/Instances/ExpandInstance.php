<?php

  namespace Doox911Opensource\LaravelOData\Tests\Classes\Core\Instances;

  use Doox911Opensource\LaravelOData\Classes\Core\Expand;
  use Doox911Opensource\ValueObjects\Exceptions\ValueObjectsException;

  final class ExpandInstance
  {

    public static function new(): Expand
    {
      return new Expand;
    }

    /**
     * @throws ValueObjectsException
     */
    public static function addExpand(string $expand): Expand
    {
      $instance = self::new();

      $instance->add($expand);

      return $instance;
    }

    /**
     * @throws ValueObjectsException
     */
    public static function addExpands(array $expands): Expand
    {
      $instance = self::new();

      foreach ($expands as $expand) {
        $instance->add($expand);
      }

      return $instance;
    }
  }
