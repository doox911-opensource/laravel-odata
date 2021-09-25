<?php

  namespace Doox911Opensource\LaravelOData\Tests\Classes\Core;

  use Orchestra\Testbench\TestCase;
  use Doox911Opensource\LaravelOData\Tests\Classes\Core\Instances\SelectInstance;

  class SelectTest extends TestCase
  {

    /**
     * Добавление полей
     */
    public function testAdd()
    {
      $field = 'ИНН';

      $select = SelectInstance::addSelect($field)->selects()->last()->value;

      $this->assertSame($field, $select);
    }

    /**
     * Преобразование в массив
     */
    public function testToArray()
    {
      $fields = [
        'ИНН',
        'ОКПО',
        'Ref_Key',
      ];

      $expected = [
        0 => [
          'value' => 'ИНН',
        ],
        1 => [
          'value' => 'ОКПО',
        ],
        2 => [
          'value' => 'Ref_Key',
        ],
      ];

      $select = SelectInstance::addSelects($fields);

      $this->assertSame($expected, $select->toArray());
    }

    /**
     * Преобразование в строку
     */
    public function testToQuery()
    {
      $fields = [
        'ИНН',
        'ОКПО',
        'Ref_Key',
      ];

      $expected = '%24select=%D0%98%D0%9D%D0%9D,%D0%9E%D0%9A%D0%9F%D0%9E,Ref_Key';

      $select = SelectInstance::addSelects($fields);

      $this->assertSame($expected, $select->toQuery());
    }
  }
