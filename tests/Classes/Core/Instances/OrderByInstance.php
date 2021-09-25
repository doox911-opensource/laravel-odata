<?php

  namespace Doox911Opensource\LaravelOData\Tests\Classes\Core\Instances;

  use Doox911Opensource\LaravelOData\Classes\Core\OrderBy;
  use Doox911Opensource\LaravelOData\Classes\Enums\OrderBy as EnumOrderBy;
  use Doox911Opensource\ValueObjects\Exceptions\ValueObjectsException;

  final class OrderByInstance
  {

    /**
     * @return OrderBy
     */
    public static function new(): OrderBy
    {
      return new OrderBy;
    }

    /**
     * @throws ValueObjectsException
     */
    public static function addOrderAsc(string $field): OrderBy
    {
      $instance = self::new();

      $instance->addOrder($field, EnumOrderBy::ASC());

      return $instance;
    }

    /**
     * @throws ValueObjectsException
     */
    public static function addOrderDesc(string $field): OrderBy
    {
      $instance = self::new();

      $instance->addOrder($field, EnumOrderBy::DESC());

      return $instance;
    }

    /**
     * @throws ValueObjectsException
     */
    public static function addOrders(array $orders): OrderBy
    {
      $instance = self::new();

      foreach ($orders as $order) {
        $instance->addOrder($order['field'], $order['order']);
      }

      return $instance;
    }
  }
