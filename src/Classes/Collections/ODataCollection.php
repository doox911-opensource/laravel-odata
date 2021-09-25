<?php

  namespace Doox911Opensource\LaravelOData\Classes\Collections;

  use function count;
  use function array_values;
  use function array_search;
  use function array_key_last;
  use function array_key_first;
  use Doox911Opensource\LaravelOData\Classes\Enums\CollectionAlias;
  use Doox911Opensource\LaravelOData\Exceptions\LaravelODataException;
  use Doox911Opensource\LaravelOData\Contracts\ODataCollectionContract;

  /**
   * @property array items Элементы коллекции
   */
  class ODataCollection implements ODataCollectionContract
  {

    protected array $items;

    /**
     * Тип элементов коллекции
     */
    protected string $type = 'mixed';

    public function __construct(...$items)
    {
      $this->items = [];

      if (count($items)) {
        foreach ($items as $item) {
          $this->validateType($item, $this->type);
        }

        $this->items = [...$items];
      }
    }

    /**
     * @param mixed $item Элемент коллекции
     * @return ODataCollectionContract
     * @see ODataCollectionContract::add()
     */
    public function add(mixed $item): ODataCollectionContract
    {
      $this->validateType($item, $this->type);

      $this->items[] = $item;

      return $this;
    }

    /**
     * @return ODataCollectionContract
     * @see ODataCollectionContract::clear()
     */
    final public function clear(): ODataCollectionContract
    {
      $this->items = [];

      return $this;
    }

    /**
     * @return ODataCollectionContract
     * @see ODataCollectionContract::copy
     */
    final public function copy(): ODataCollectionContract
    {
      return new static(...$this->items);
    }

    /**
     * @return bool
     * @see ODataCollectionContract::isEmpty()
     */
    final public function isEmpty(): bool
    {
      return !count($this->items);
    }

    /**
     * @return array
     * @see ODataCollectionContract::toArray()
     */
    public function toArray(): array
    {
      return [...$this->items];
    }

    /**
     * @return int
     * @see ODataCollectionContract::length()
     */
    final public function length(): int
    {
      return count($this->items);
    }

    /**
     * @return int|string|null
     * @see ODataCollectionContract::lastKey()
     */
    final public function lastKey(): int|string|null
    {
      return array_key_last($this->items);
    }

    /**
     * @return int|string|null
     * @see ODataCollectionContract::firstKey()
     */
    final public function firstKey(): int|string|null
    {
      return array_key_first($this->items);
    }

    /**
     * @return mixed
     * @see ODataCollectionContract::last()
     */
    final public function last(): mixed
    {
      return $this->items[array_key_last($this->items)];
    }

    /**
     * @return mixed
     * @see ODataCollectionContract::first()
     */
    final public function first(): mixed
    {
      return $this->items[array_key_first($this->items)];
    }

    /**
     * @param mixed $item Элемент коллекции
     * @return int|string|null
     * @see ODataCollectionContract::getItemKey()
     */
    final public function getItemKey(mixed $item): int|string|null
    {
      return array_search($item, $this->items);
    }

    /**
     * @param mixed $item Элемент коллекции
     * @return $this
     * @see ODataCollectionContract::removeItem()
     */
    final public function removeItem(mixed $item): ODataCollection
    {
      unset($this->items[$this->getItemKey($item)]);

      $this->items = array_values($this->items);

      return $this;
    }

    /**
     * @throws LaravelODataException
     */
    public function __get(string $name)
    {
      if ($name === (string)CollectionAlias::ITEMS()) {
        return $this->{$name};
      }

      throw new LaravelODataException('Invalid property');
    }

    /**
     * Валидация типа элемента коллекции
     *
     * Вызывается в конструкторе.
     *
     * @param mixed $item Элемент коллекции
     * @param string $type Тип элемента
     * @return void
     */
    protected function validateType(mixed $item, string $type): void
    {

    }
  }
