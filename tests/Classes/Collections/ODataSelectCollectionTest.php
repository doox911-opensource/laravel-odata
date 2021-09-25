<?php

  namespace Doox911Opensource\LaravelOData\Tests\Classes\Collections;

  use Orchestra\Testbench\TestCase;
  use Doox911Opensource\ValueObjects\Exceptions\ValueObjectsException;
  use Doox911Opensource\LaravelOData\Exceptions\LaravelODataException;
  use Doox911Opensource\LaravelOData\Classes\ValueObjects\ODataSelect;
  use Doox911Opensource\LaravelOData\Classes\Collections\ODataSelectCollection;

  class ODataSelectCollectionTest extends TestCase
  {

    /**
     * @throws ValueObjectsException
     */
    public function testCreate()
    {
      $item1 = new ODataSelect([
        'value' => 'ХарактеристикаНоменклатуры/Description'
      ]);

      $item2 = new ODataSelect([
        'value' => 'ХарактеристикаНоменклатуры/Цена'
      ]);

      $collection = $this->createCollection($item1, $item2);

      $this->assertSame([$item1, $item2], $collection->toArray());
    }

    /**
     * @throws ValueObjectsException
     */
    public function testAdd()
    {
      $item = new ODataSelect([
        'value' => 'ХарактеристикаНоменклатуры/Description'
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

    protected function createCollection(...$items): ODataSelectCollection
    {
      return new ODataSelectCollection(...$items);
    }

  }
