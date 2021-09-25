<?php

  namespace Doox911Opensource\LaravelOData\Tests\Classes\Core\Instances;

  use Doox911Opensource\LaravelOData\Classes\Core\Filter;

  final class FilterInstance
  {

    public static function new(): Filter
    {
      return new Filter;
    }

    public static function addFilter(string $field, string $operator, string $value): Filter
    {
      $filter = self::new();

      $filter->add($field, $operator, $value);

      return $filter;
    }

    public static function orAddFilter(string $field, string $operator, string $value): Filter
    {
      $filter = self::new();

      $filter->orAdd($field, $operator, $value);

      return $filter;
    }

    public static function scope(): Filter
    {
      $filter = self::new();

      return $filter->scope(fn($filter) => $filter);
    }

    public static function createEmptyScopes(int $quality): Filter
    {
      $filter = self::new();

      for ($i = 0; $i < $quality; $i++) {
        $filter->scope(fn($filter) => $filter);
      }

      return $filter;
    }

    public static function toArray(string $field, string $operator, string $value): array
    {
      $filter = self::addFilter($field, $operator, $value);

      return $filter->toArray();
    }

    public static function toString(string $field, string $operator, string $value): string
    {
      $filter = self::addFilter($field, $operator, $value);

      return (string)$filter;
    }

    public static function encodeToString(string $field, string $operator, string $value): string
    {
      $filter = self::addFilter($field, $operator, $value);

      return $filter->encodeToString();
    }
  }
