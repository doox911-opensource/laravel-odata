<?php

  namespace Doox911Opensource\LaravelOData\Classes\Core;

  use function rtrim;
  use JetBrains\PhpStorm\Pure;
  use Doox911Opensource\LaravelOData\Traits\Core\ToQuery;
  use Doox911Opensource\LaravelOData\Classes\Enums\OrderBy as EnumOrderBy;
  use Doox911Opensource\LaravelOData\Classes\Enums\QueryOption;
  use Doox911Opensource\LaravelOData\Contracts\QueryOptionContract;
  use Doox911Opensource\ValueObjects\Exceptions\ValueObjectsException;
  use Doox911Opensource\LaravelOData\Classes\ValueObjects\ODataOrderBy;
  use Doox911Opensource\LaravelOData\Classes\Collections\ODataCollection;

  final class OrderBy implements QueryOptionContract
  {
    use ToQuery;

    private ODataCollection $orders;

    /**
     * @throws ValueObjectsException
     */
    public function __construct(
      private ?string $field = null,
      private ?OrderBy $order = null,
      private ?Grammar $grammar = null
    )
    {
      $this->orders = new ODataCollection();

      if ($field !== null) {
        $this->addOrder($field, $order ?? EnumOrderBy::ASC());
      }

      $this->grammar = $grammar ?? new Grammar;
    }

    /**
     * Добавить порядок выборки
     *
     * @throws ValueObjectsException
     */
    public function addOrder(string $filed, ?EnumOrderBy $order = null): OrderBy
    {
      $order = $this->createODataOrderBy($filed, $order);

      $this->orders->add($order);

      return $this;
    }

    /**
     * @return string
     * @see QueryOptionContract::getQueryPrefix
     */
    public function getQueryPrefix(): string
    {
      return '$' . QueryOption::ORDER_BY();
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
      $selects = [];

      foreach ($this->orders->toArray() as $order) {
        $orders[] = $order->toArray();
      }

      return $selects;
    }

    /**
     * @return string
     */
    #[Pure]
    public function __toString(): string
    {
      $string = '';

      foreach ($this->orders->items as $order) {
        $string .= $order . ',';
      }

      return rtrim($string, ',');
    }

    /**
     * @throws ValueObjectsException
     */
    private function createODataOrderBy(string $filed, EnumOrderBy $order): ODataOrderBy
    {
      return new ODataOrderBy([
        'field' => $filed,
        'order' => $order,
      ]);
    }
  }
