<?php

  namespace Doox911Opensource\LaravelOData\Tests\Classes\Collections;

  use Orchestra\Testbench\TestCase;
  use Doox911Opensource\LaravelOData\Classes\Collections\ODataCollection;

  class ODataCollectionTest extends TestCase
  {

    /**
     * Копировать коллекцию
     */
    public function testCopy()
    {
      $collection = $this->createCollection('element', [], 1);

      $this->assertSame($collection->toArray(), $collection->copy()->toArray());
    }

    /**
     * Получить коллекцию в виде массива
     */
    public function testToArray()
    {
      $collection = $this->createCollection('element', [], 1);

      $this->assertSame([
        'element',
        [],
        1
      ], $collection->toArray());
    }

    /**
     * Проверка на пустоту коллекции
     */
    public function testIsEmpty()
    {
      $this->assertTrue($this->createCollection()->isEmpty());
    }

    /**
     * Проверка наличия элементов
     */
    public function testIsNotEmpty()
    {
      $this->assertFalse($this->createCollection('element')->isEmpty());
    }

    /**
     * Добавить элемент
     */
    public function testAdd()
    {
      $item = 'element';

      $collection = $this->createCollection();

      $collection->add($item);

      $this->assertSame($item, $collection->toArray()[0]);
    }

    /**
     * Очистить коллекцию
     */
    public function testClear()
    {
      $collection = $this->createCollection('element', [], 1);

      $this->assertTrue($collection->clear()->isEmpty());
    }

    /**
     * Количество элементов коллекции
     */
    public function testLength()
    {
      $collection = $this->createCollection('element', [], 1);

      $this->assertSame(3, $collection->length());
    }

    /**
     * Ключ последнего элемента
     */
    public function testLastKey()
    {
      $collection = $this->createCollection('element', [], 1);

      $this->assertSame(2, $collection->lastKey());
    }

    /**
     * Ключ первого элемента
     */
    public function testFirstKey()
    {
      $collection = $this->createCollection('element', [], 1);

      $this->assertSame(0, $collection->firstKey());
    }

    /**
     * Последний элемент
     */
    public function testLast()
    {
      $collection = $this->createCollection('element', [], 1);

      $this->assertSame(1, $collection->last());
    }

    /**
     * Первый элемент
     */
    public function testFirst()
    {
      $collection = $this->createCollection('element', [], 1);

      $this->assertSame('element', $collection->first());
    }

    /**
     * Получить ключ элемента
     */
    public function testGetItemKey()
    {
      $item = [];

      $collection = $this->createCollection('element', $item, 1);

      $this->assertSame(1, $collection->getItemKey($item));
    }

    /**
     * Создать коллекцию
     *
     * @param mixed ...$items
     * @return ODataCollection
     */
    protected function createCollection(...$items): ODataCollection
    {
      return new ODataCollection(...$items);
    }
  }
