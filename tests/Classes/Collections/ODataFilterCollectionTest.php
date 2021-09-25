<?php

  namespace Doox911Opensource\LaravelOData\Tests\Classes\Collections;

  use Orchestra\Testbench\TestCase;
  use Doox911Opensource\LaravelOData\Classes\Enums\LogicalOperator;
  use Doox911Opensource\LaravelOData\Exceptions\LaravelODataException;
  use Doox911Opensource\LaravelOData\Classes\ValueObjects\ODataFilter;
  use Doox911Opensource\ValueObjects\Exceptions\ValueObjectsException;
  use Doox911Opensource\LaravelOData\Classes\Collections\ODataFilterCollection;

  class ODataFilterCollectionTest extends TestCase
  {

    /**
     * @throws ValueObjectsException
     */
    public function testCreate()
    {
      $item1 = new ODataFilter([
        'field' => 'ТипЦен/Owner/ИНН',
        'connection_operator' => LogicalOperator::AND(),
        'operator' => 'eq',
        'value' => '\'000000000000\'',
      ]);

      $item2 = new ODataFilter([
        'field' => 'ТипЦен/Owner/ИНН',
        'connection_operator' => LogicalOperator::AND(),
        'operator' => 'eq',
        'value' => '\'000000000001\'',
      ]);

      $collection = $this->createCollection($item1, $item2);

      $this->assertSame([$item1, $item2], $collection->toArray());
    }

    /**
     * @throws ValueObjectsException
     */
    public function testAdd()
    {
      $item = new ODataFilter([
        'field' => 'ТипЦен/Owner/ИНН',
        'connection_operator' => LogicalOperator::AND(),
        'operator' => 'eq',
        'value' => '\'000000000000\'',
      ]);

      $collection = $this->createCollection();

      $collection->add($item);

      $this->assertSame($item, $collection->toArray()[0]);
    }

    public function testAddInvalidArgument()
    {
      $this->expectException(LaravelODataException::class);

      $this->createCollection('element');
    }

    protected function createCollection(...$items): ODataFilterCollection
    {
      return new ODataFilterCollection(...$items);
    }
  }
