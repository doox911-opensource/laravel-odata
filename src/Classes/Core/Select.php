<?php

  namespace Doox911Opensource\LaravelOData\Classes\Core;

  use function rtrim;
  use Doox911Opensource\LaravelOData\Traits\Core\ToQuery;
  use Doox911Opensource\LaravelOData\Contracts\GrammarContract;
  use Doox911Opensource\LaravelOData\Classes\Enums\QueryOption;
  use Doox911Opensource\LaravelOData\Contracts\QueryOptionContract;
  use Doox911Opensource\LaravelOData\Classes\ValueObjects\ODataSelect;
  use Doox911Opensource\ValueObjects\Exceptions\ValueObjectsException;
  use Doox911Opensource\LaravelOData\Contracts\ODataCollectionContract;
  use Doox911Opensource\LaravelOData\Classes\Collections\ODataSelectCollection;

  final class Select implements QueryOptionContract
  {
    use ToQuery;

    public function __construct(
      private ?ODataSelectCollection $selects = null,
      private ?GrammarContract $grammar = null,
    )
    {
      $this->selects = $selects ?? new ODataSelectCollection;
      $this->grammar = $grammar ?? new Grammar;
    }

    /**
     * Добавить поле
     *
     * @param string $select Поле
     * @return Select
     * @throws ValueObjectsException
     */
    public function add(string $select): Select
    {
      $odata_select = $this->createOdataSelect($select);

      $this->selects->add($odata_select);

      return $this;
    }

    /**
     * @return string
     * @see QueryOptionContract::getQueryPrefix
     */
    public function getQueryPrefix(): string
    {
      return '$' . QueryOption::SELECT();
    }

    /**
     * Получить коллекцию полей
     *
     * @return ODataCollectionContract
     */
    public function selects(): ODataCollectionContract
    {
      return $this->selects;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
      $selects = [];

      foreach ($this->selects->toArray() as $select) {
        $selects[] = $select->toArray();
      }

      return $selects;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
      $string = '';

      foreach ($this->selects->items as $select) {
        $string .= $select . ',';
      }

      return rtrim($string, ',');
    }

    /**
     * @param string $select Поле
     * @return ODataSelect
     * @throws ValueObjectsException
     */
    protected function createOdataSelect(string $select): ODataSelect
    {
      return new ODataSelect([
        'value' => $select
      ]);
    }
  }
