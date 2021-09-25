<?php

  namespace Doox911Opensource\LaravelOData\Tests\Classes\ValueObjects;

  use Orchestra\Testbench\TestCase;
  use Doox911Opensource\LaravelOData\Classes\Enums\LogicalOperator;
  use Doox911Opensource\ValueObjects\Exceptions\ValueObjectsException;
  use Doox911Opensource\LaravelOData\Tests\Classes\ValueObjects\Instances\ODataFilterInstance;

  class ODataFilterTest extends TestCase
  {

    /**
     * В массив
     *
     * @throws ValueObjectsException
     */
    public function testToArrayAndToToArrayFromStore()
    {
      $array_filter = [
        'field' => 'ИНН',
        'operator' => 'eq',
        'value' => '\'0000000000\'',
        'connection_operator' => LogicalOperator::AND(),
      ];

      $filter = ODataFilterInstance::new(
        $array_filter['field'],
        $array_filter['operator'],
        $array_filter['value'],
        $array_filter['connection_operator'],
      );

      $this->assertEquals($array_filter, $filter->toArray());
      $this->assertEquals($array_filter, $filter->toArrayFromStore());
    }
  }
