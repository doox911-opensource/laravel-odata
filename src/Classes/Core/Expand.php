<?php

  namespace Doox911Opensource\LaravelOData\Classes\Core;

  use function rtrim;
  use Doox911Opensource\LaravelOData\Traits\Core\ToQuery;
  use Doox911Opensource\LaravelOData\Contracts\GrammarContract;
  use Doox911Opensource\LaravelOData\Classes\Enums\QueryOption;
  use Doox911Opensource\LaravelOData\Contracts\QueryOptionContract;
  use Doox911Opensource\LaravelOData\Classes\ValueObjects\ODataExpand;
  use Doox911Opensource\ValueObjects\Exceptions\ValueObjectsException;
  use Doox911Opensource\LaravelOData\Contracts\ODataCollectionContract;
  use Doox911Opensource\LaravelOData\Classes\Collections\ODataExpandCollection;

  /**
   * Связанные сущности
   */
  final class Expand implements QueryOptionContract
  {
    use ToQuery;

    public function __construct(
      private ?ODataCollectionContract $expands = null,
      private ?GrammarContract $grammar = null,
    )
    {
      $this->expands = $expands ?? new ODataExpandCollection;
      $this->grammar = $grammar ?? new Grammar;
    }

    /**
     * Добавить связанную сущность
     *
     * @param string $expand Имя сущности
     * @return Expand
     * @throws ValueObjectsException
     */
    public function add(string $expand): Expand
    {
      $odata_expand = $this->createOdataExpand($expand);

      $this->expands->add($odata_expand);

      return $this;
    }

    /**
     * Получить коллекция раскрытий
     *
     * @return ODataCollectionContract
     */
    public function expands(): ODataCollectionContract
    {
      return $this->expands;
    }

    /**
     * @return string
     * @see QueryOptionContract::getQueryPrefix
     */
    public function getQueryPrefix(): string
    {
      return '$' . QueryOption::EXPAND();
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
      $expands = [];

      foreach ($this->expands->toArray() as $expand) {
        $expands[] = $expand->toArray();
      }

      return $expands;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
      $sting = '';

      foreach ($this->expands->items as $select) {
        $sting .= $select->value . ',';
      }

      return rtrim($sting, ',');
    }

    /**
     * @param string $expand Значение связанной сущности
     * @return ODataExpand
     * @throws ValueObjectsException
     */
    private function createOdataExpand(string $expand): ODataExpand
    {
      return new ODataExpand([
        'value' => $expand
      ]);
    }
  }
