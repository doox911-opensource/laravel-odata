<?php

  namespace Doox911Opensource\LaravelOData\Traits;

  use Doox911Opensource\LaravelOData\Exceptions\LaravelODataException;

  trait ValidateType
  {

    use AssertIsA;

    /**
     * @param mixed $item Элемент коллекции
     * @param string $type Тип элемента
     * @return void
     * @throws LaravelODataException
     * @see ODataCollection::validateType()
     */
    protected function validateType(mixed $item, string $type): void
    {
      $this->assertIsA($item, $type);
    }
  }
