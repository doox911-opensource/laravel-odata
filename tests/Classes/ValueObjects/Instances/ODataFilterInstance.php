<?php

  namespace Doox911Opensource\LaravelOData\Tests\Classes\ValueObjects\Instances;

  use Doox911Opensource\LaravelOData\Classes\Enums\LogicalOperator;
  use Doox911Opensource\LaravelOData\Classes\ValueObjects\ODataFilter;
  use Doox911Opensource\ValueObjects\Exceptions\ValueObjectsException;

  final class ODataFilterInstance
  {

    /**
     * @throws ValueObjectsException
     */
    public static function new(
      string $field,
      string $operator,
      string $value,
      LogicalOperator $connection_operator,
    ): ODataFilter
    {
      return new ODataFilter([
        'field' => $field,
        'operator' => $operator,
        'value' => $value,
        'connection_operator' => $connection_operator,
      ]);
    }

  }
