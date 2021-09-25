<?php

  namespace Doox911Opensource\LaravelOData\Tests\Classes\Core;

  use Orchestra\Testbench\TestCase;
  use Doox911Opensource\ValueObjects\Exceptions\ValueObjectsException;
  use Doox911Opensource\LaravelOData\Tests\Classes\Core\Instances\ExpandInstance;

  class ExpandTest extends TestCase
  {

    /**
     * Добавление полей
     *
     * @throws ValueObjectsException
     */
    public function testAdd()
    {
      $field = 'ИНН';

      $select = ExpandInstance::addExpand($field)->expands()->last()->value;

      $this->assertSame($field, $select);
    }

    /**
     * Преобразование в массив
     *
     * @throws ValueObjectsException
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

      $select = ExpandInstance::addExpands($fields);

      $this->assertSame($expected, $select->toArray());
    }

    /**
     * Преобразование в строку
     *
     * @throws ValueObjectsException
     */
    public function testToQuery()
    {
      $fields = [
        'ИНН',
        'ОКПО',
        'Ref_Key',
      ];

      $expected = '%24expand=%D0%98%D0%9D%D0%9D,%D0%9E%D0%9A%D0%9F%D0%9E,Ref_Key';

      $select = ExpandInstance::addExpands($fields);

      $this->assertSame($expected, $select->toQuery());
    }
  }
