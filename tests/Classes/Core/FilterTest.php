<?php

  namespace Doox911Opensource\LaravelOData\Tests\Classes\Core;

  use Orchestra\Testbench\TestCase;
  use Doox911Opensource\LaravelOData\Classes\Enums\LogicalOperator;
  use Doox911Opensource\LaravelOData\Tests\Classes\Core\Instances\FilterInstance;
  use Doox911Opensource\LaravelOData\Tests\Classes\ValueObjects\Instances\ODataFilterInstance;

  class FilterTest extends TestCase
  {

    /**
     * Добавление фильтра
     *
     * Оператор соединения AND
     */
    public function testAdd()
    {
      $odata_filter = ODataFilterInstance::new(
        'ИНН',
        'eq',
        '\'0000000000\'',
        LogicalOperator::AND()
      );

      $filters = FilterInstance::addFilter('ИНН', 'eq', '\'0000000000\'');

      $filter = $filters->filters()->last();

      $this->assertSame($odata_filter->field, $filter->field);
      $this->assertSame($odata_filter->operator, $filter->operator);
      $this->assertSame($odata_filter->value, $filter->value);
      $this->assertEquals($odata_filter->connection_operator, $filter->connection_operator);
    }

    /**
     * Добавление фильтра
     *
     * Оператор соединения OR
     */
    public function testOrAdd()
    {
      $odata_filter = ODataFilterInstance::new(
        'ИНН',
        'eq',
        '\'0000000000\'',
        LogicalOperator::OR()
      );

      $filters = FilterInstance::orAddFilter('ИНН', 'eq', '\'0000000000\'');

      $filter = $filters->filters()->last();

      $this->assertSame($odata_filter->field, $filter->field);
      $this->assertSame($odata_filter->operator, $filter->operator);
      $this->assertSame($odata_filter->value, $filter->value);
      $this->assertEquals($odata_filter->connection_operator, $filter->connection_operator);
    }

    /**
     * Работоспособность области
     */
    public function testScope()
    {
      $this->assertInstanceOf(FilterInstance::new()::class, FilterInstance::scope());
    }

    /**
     * Отсутствие пустых областей
     */
    public function testAvailableScopes()
    {
      $filter = FilterInstance::createEmptyScopes(3);

      $this->assertSame(1, $filter->getScopes()->length());
    }

    /**
     * Преобразование фильтра в массив
     */
    public function testToArray()
    {
      $array = [
        0 => [
          'field' => 'ИНН',
          'operator' => 'eq',
          'connection_operator' => LogicalOperator::AND(),
          'value' => '\'0000000000\'',
        ],
      ];

      $filters = FilterInstance::toArray('ИНН', 'eq', '\'0000000000\'');

      $this->assertEquals($array, $filters);
    }

    /**
     * Преобразование фильтра в строку
     *
     * Ожидаются фильтры в виде строки для вставки в запрос
     */
    public function testToString()
    {
      $string = FilterInstance::toString('ИНН', 'eq', '\'0000000000\'');

      $expecting = 'ИНН eq \'0000000000\'';

      $this->assertSame($expecting, $string);
    }

    /**
     * Преобразование фильтра в строку
     *
     * Ожидаются фильтры в виде строки для вставки в запрос
     */
    public function testEncodeToString()
    {
      $string = FilterInstance::encodeToString('ИНН', 'eq', '\'0000000000\'');

      $expecting = '%D0%98%D0%9D%D0%9D%20eq%20\'0000000000\'';

      $this->assertSame($expecting, $string);
    }
  }
