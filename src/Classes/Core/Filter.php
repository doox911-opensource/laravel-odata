<?php

  namespace Doox911Opensource\LaravelOData\Classes\Core;

  use function trim;
  use function count;
  use function substr;
  use function strlen;
  use JetBrains\PhpStorm\Pure;
  use function str_starts_with;
  use Doox911Opensource\LaravelOData\Classes\Enums\LogicalOperator;
  use Doox911Opensource\LaravelOData\Classes\ValueObjects\ODataFilter;
  use Doox911Opensource\ValueObjects\Exceptions\ValueObjectsException;
  use Doox911Opensource\LaravelOData\Contracts\ODataCollectionContract;
  use Doox911Opensource\LaravelOData\Classes\Collections\ODataCollection;
  use Doox911Opensource\LaravelOData\Classes\Collections\ODataFilterCollection;
  use Doox911Opensource\LaravelOData\Classes\Enums\QueryOption;
  use Doox911Opensource\LaravelOData\Traits\Core\ToQuery;
  use Doox911Opensource\LaravelOData\Contracts\QueryOptionContract;

  final class Filter implements QueryOptionContract
  {
    use ToQuery;

    private const SPACE = ' ';

    /**
     * Фильтры
     */
    private ODataFilterCollection $filters;

    /**
     * Области
     */
    private ODataCollection $scopes;

    /**
     * Активная область
     */
    private ?Scope $active_scope;

    private Grammar $grammar;

    /**
     * Операторы
     */
    private array $available_connection_operators;

    public function __construct()
    {
      $this->available_connection_operators = [
        LogicalOperator::AND(),
        LogicalOperator::OR(),
      ];

      $this->filters = new ODataFilterCollection;

      $this->scopes = new ODataCollection;

      $this->active_scope = null;

      $this->appendScope();

      $this->grammar = new Grammar();
    }

    /**
     * Коллекция фильтров
     *
     * @return ODataCollectionContract
     */
    public function filters(): ODataCollectionContract
    {
      return $this->filters;
    }

    /**
     * @return string
     * @see QueryOptionContract::getQueryPrefix
     */
    public function getQueryPrefix(): string
    {
      return '$' . QueryOption::FILTER();
    }

    /**
     * Коллекция областей
     *
     * @return ODataCollectionContract
     */
    #[Pure]
    public function getScopes(): ODataCollectionContract
    {
      return $this->scopes;
    }

    /**
     * Активная область
     *
     * @return Scope|null
     */
    public function getActiveScope(): ?Scope
    {
      return $this->active_scope;
    }

    /**
     * Установить активную область
     *
     * @param Scope $scope Область
     * @return Filter
     */
    public function setActiveScope(Scope $scope): Filter
    {
      $this->active_scope = $scope;

      return $this;
    }

    /**
     * Добавить фильтр
     *
     * Соединяется оператором AND
     *
     * @param string $field Поле
     * @param string $operator Оператор
     * @param int|string $value Значение
     * @return Filter
     * @throws ValueObjectsException
     * @see Filter::addFilter()
     */
    public function add(string $field, string $operator, int|string $value): Filter
    {
      return $this->addFilter($field, $operator, $value, LogicalOperator::AND());
    }

    /**
     * Добавить фильтр
     *
     * Соединяется оператором OR
     *
     * @param string $field Поле
     * @param string $operator Оператор
     * @param int|string $value Значение
     * @return Filter
     * @return $this
     * @throws ValueObjectsException
     * @see Filter::addFilter()
     */
    public function orAdd(string $field, string $operator, int|string $value): Filter
    {
      return $this->addFilter($field, $operator, $value, LogicalOperator::OR());
    }

    /**
     * Добавить область
     *
     * Оператор соединения - AND
     *
     * @param callable $callable
     * @return $this
     */
    public function scope(callable $callable): Filter
    {
      return $this->addScope(LogicalOperator::AND(), $callable);
    }

    /**
     * Добавить область
     *
     * Оператор соединения - OR
     *
     * @param callable $callable
     * @return $this
     */
    public function orScope(callable $callable): Filter
    {
      return $this->addScope(LogicalOperator::OR(), $callable);
    }

    /**
     * Обернуть значение фильтра в guid
     *
     * Обернёт значение последнего добавленного фильтра
     *
     * @return $this
     * @throws ValueObjectsException
     */
    public function guid(): Filter
    {
      $filter = $this->filters->last();

      $this->filters->removeItem($filter);

      $filter = $this->createOdataFilter(
        $filter->field,
        $filter->operator,
        'guid' . $filter->value,
        $filter->connection_operator
      );

      $this->filters->add($filter);

      $this->addToScope($this->filters->lastKey());

      return $this;
    }

    public function __toString(): string
    {
      return $this->toString();
    }

    #[Pure]
    public function toArray(): array
    {
      $filters = [];

      foreach ($this->filters->toArray() as $filter) {
        $filters[] = $filter->toArray();
      }

      return $filters;
    }

    /**
     * Добавить фильтр
     *
     * @param string $field Поле
     * @param string $operator Оператор
     * @param int|string $value Значение
     * @param LogicalOperator $connection_operator Оператор соединения(and|or)
     * @return $this
     * @throws ValueObjectsException
     */
    protected function addFilter(string $field, string $operator, int|string $value, LogicalOperator $connection_operator): Filter
    {
      $value = $this->grammar->prepareODataValue($value);

      $filter = $this->createOdataFilter($field, $operator, $value, $connection_operator);

      $this->filters->add($filter);

      $this->addToScope($this->filters->lastKey());

      return $this;
    }

    protected function addScope(LogicalOperator $operator, callable $callable): Filter
    {
      $rollback_scope = $this->getActiveScope();

      $this->appendScope($operator);

      $callable($this);

      $this
        ->clearEmptyScope()
        ->setActiveScope($rollback_scope);

      return $this;
    }

    /**
     * Добавить область
     *
     * @param ?LogicalOperator $operator Оператор соединения
     * @param int|string|null $key Индекс фильтра в коллекции
     * @return Scope
     */
    private function appendScope(?LogicalOperator $operator = null, null|int|string $key = null): Scope
    {
      if ($operator === null) {
        $operator = LogicalOperator::AND();
      }

      $scope = $this
        ->scopes
        ->add($this->createScope($operator, $key))
        ->last();

      $scope_key = $this->getActiveScope()
        ? $this
          ->scopes
          ->getItemKey($this->getActiveScope())
        : null;

      $scope->setParentKey($scope_key);

      $this->setActiveScope($scope);

      return $scope;
    }

    /**
     * Добавить фильтр в область
     *
     * @param int|string $key Индекс фильтра в коллекции
     * @return Filter
     */
    private function addToScope(int|string $key): Filter
    {
      $this
        ->active_scope
        ->addKey($key);

      return $this;
    }

    /**
     * Создать фильтр
     *
     * @param string $field Поле
     * @param string $operator Оператор
     * @param string $value Значение
     * @param LogicalOperator $connection_operator Оператор соединения
     * @return ODataFilter
     * @throws ValueObjectsException
     */
    private function createOdataFilter(
      string $field,
      string $operator,
      string $value,
      LogicalOperator $connection_operator): OdataFilter
    {
      return new ODataFilter([
        'field' => $field,
        'operator' => $operator,
        'connection_operator' => $connection_operator,
        'value' => $value,
      ]);
    }

    /**
     * Создать область
     *
     * @param LogicalOperator $operator Оператор соединения
     * @param int|string|null $key Ключ фильтра
     * @return Scope
     */
    private function createScope(LogicalOperator $operator, null|int|string $key): Scope
    {
      return new Scope($operator, $key);
    }

    /**
     * Преобразовать фильтр в строку
     *
     * @param array $scopes Области
     * @param string $string Фильтры
     * @param null|int|string $parent_key Родитель области
     * @return string
     */
    private function convertToString(
      array $scopes,
      string $string = '',
      null|int|string $parent_key = null): string
    {
      foreach ($scopes as $index => $scope) {
        $key = $scope->getParentKey();

        if ($key === $parent_key) {

          $string .=
            self::SPACE .
            $scope->getOperator() .
            self::SPACE . '(';

          foreach ($scope->getKeys() as $filter_key) {
            $string .=
              $this->filters->items[$filter_key]->connection_operator .
              self::SPACE .
              $this->filters->items[$filter_key] .
              self::SPACE;

            $search = '(' . $this->filters->items[$filter_key]->connection_operator . self::SPACE;

            $string = str_replace($search, '(', $string);
          }

          $string = trim($string, self::SPACE);

          $string = $this->convertToString($scopes, $string, $index);

          $string .= ')';
        }
      }

      return $this->leftTrimmer($string, '', self::SPACE . '(');
    }

    /**
     * Обрезать строку слева
     *
     * Удалить операторы соединения после конвертации фильтров в строку
     *
     * @param string $string Фильтры
     * @param string $prefix Префикс оператора
     * @param string $postfix Постфикс оператора
     * @return string
     */
    private function leftTrimmer(string $string, string $prefix = '', string $postfix = ''): string
    {
      foreach ($this->available_connection_operators as $operator) {
        if (str_starts_with($string, $prefix . $operator . $postfix)) {
          $string = substr($string, strlen($prefix . $operator . $postfix));
        }
      }

      return $string;
    }

    /**
     * В строку
     *
     * @return string
     */
    private function toString(): string
    {
      $string = $this->convertToString($this->scopes->items);

      /**
       * Необходимо обрезать лишнюю скобку в конце
       */
      return substr($string, 0, -1);
    }

    /**
     * Очистить пустые области
     *
     * @return Filter
     */
    private function clearEmptyScope(): Filter
    {
      foreach ($this->scopes->items as $scope) {

        /**
         * Не удаляем корневую область
         */
        if ($this->scopes->length() > 1) {
          if (!count($scope->getKeys())) {
            $this->scopes->removeItem($scope);
          }
        }
      }

      return $this;
    }
  }
