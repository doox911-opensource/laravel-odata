<?php

  namespace Doox911Opensource\LaravelOData\Tests\Classes\Core;

  use Orchestra\Testbench\TestCase;
  use Doox911Opensource\LaravelOData\Classes\Enums\OrderBy;
  use Doox911Opensource\ValueObjects\Exceptions\ValueObjectsException;
  use Doox911Opensource\LaravelOData\Tests\Classes\Core\Instances\OrderByInstance;

  class OrderByTest extends TestCase
  {

    /**
     * От меньшего к большему
     *
     * @throws ValueObjectsException
     */
    public function testAddOrderAsc()
    {
      $field = 'ИНН';

      $expected = 'ИНН' . ' ' . OrderBy::ASC();

      $order = OrderByInstance::addOrderAsc($field);

      $this->assertSame($expected, (string)$order);
    }

    /**
     * От большего к меньшему
     *
     * @throws ValueObjectsException
     */
    public function testAddOrderDesc()
    {
      $field = 'ИНН';

      $expected = 'ИНН' . ' ' . OrderBy::DESC();

      $order = OrderByInstance::addOrderDesc($field);

      $this->assertSame($expected, (string)$order);
    }

    /**
     * В параметр запроса
     *
     * @throws ValueObjectsException
     */
    public function testToQuery()
    {
      $fields = [
        [
          'field' => 'ИНН',
          'order' => OrderBy::ASC()
        ],
        [
          'field' => 'ОКПО',
          'order' => OrderBy::DESC()
        ],
      ];

      $expected = '%24orderby=%D0%98%D0%9D%D0%9D%20asc,%D0%9E%D0%9A%D0%9F%D0%9E%20desc';

      $order = OrderByInstance::addOrders($fields);

      $this->assertSame($expected, $order->toQuery());
    }
  }
