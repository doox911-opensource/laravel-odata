<?php

  namespace Doox911Opensource\LaravelOData\Contracts;

  interface ODataCollectionContract
  {

    /**
     * Добавить элемент
     *
     * @param mixed $item Элемент коллекции
     * @return ODataCollectionContract
     */
    public function add(mixed $item): ODataCollectionContract;

    /**
     * Очистить коллекцию
     *
     * @return ODataCollectionContract
     */
    public function clear(): ODataCollectionContract;

    /**
     * Копировать коллекцию
     *
     * @return ODataCollectionContract
     */
    public function copy(): ODataCollectionContract;

    /**
     * Проверка на пустоту коллекции
     *
     * @return bool
     */
    public function isEmpty(): bool;

    /**
     * Получить коллекцию в виде массива
     *
     * @return array
     */
    public function toArray(): array;

    /**
     * Количество элементов коллекции
     *
     * @return int
     */
    public function length(): int;

    /**
     * Ключ последнего элемента
     *
     * @return int|string|null
     */
    public function lastKey(): int|string|null;

    /**
     * Ключ первого элемента
     *
     * @return int|string|null
     */
    public function firstKey(): int|string|null;

    /**
     * Последний элемент
     *
     * @return mixed
     */
    public function last(): mixed;

    /**
     * Первый элемент
     *
     * @return mixed
     */
    public function first(): mixed;

    /**
     * Получить ключ элемента
     *
     * @param mixed $item Элемент коллекции
     * @return int|string|null
     */
    public function getItemKey(mixed $item): int|string|null;

    /**
     * Удалить элемент из коллекции
     *
     * @param mixed $item Элемент коллекции
     * @return ODataCollectionContract
     * @see ODataCollectionContract::removeItem()
     */
    public function removeItem(mixed $item): ODataCollectionContract;
  }
