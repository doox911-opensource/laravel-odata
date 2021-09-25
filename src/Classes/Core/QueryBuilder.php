<?php

  namespace Doox911Opensource\LaravelOData\Classes\Core;

  use Closure;
  use function rtrim;
  use function strlen;
  use function in_array;
  use function func_get_args;
  use JetBrains\PhpStorm\Pure;
  use function property_exists;
  use Psr\Http\Message\ResponseInterface;
  use Doox911Opensource\LaravelOData\Classes\Enums\Root;
  use Doox911Opensource\LaravelOData\Classes\Enums\OrderBy as EnumOrderBy;
  use Doox911Opensource\LaravelOData\Classes\Enums\HTTPMethod;
  use Doox911Opensource\LaravelOData\Classes\Enums\QueryOption;
  use Doox911Opensource\LaravelOData\Contracts\ODataClientContract;
  use Doox911Opensource\LaravelOData\Contracts\QueryBuilderContract;
  use Doox911Opensource\LaravelOData\Classes\ValueObjects\ODataEntity;
  use Doox911Opensource\ValueObjects\Exceptions\ValueObjectsException;
  use Doox911Opensource\LaravelOData\Exceptions\LaravelODataException;
  use Doox911Opensource\LaravelOData\Contracts\ODataCollectionContract;

  final class QueryBuilder implements QueryBuilderContract
  {

    private array $bind_query_options = [];

    private ODataClientContract $client;

    private ?ODataEntity $entity;

    private ?string $count = null;

    private Expand $expand;

    private Filter $filter;

    private Finder $finder;

    private Format $format;

    private Grammar $grammar;

    private OrderBy $order_by;

    private Select $select;

    private ?Slice $slice_first;

    private ?Slice $slice_last;

    private Skip $skip;

    private Top $top;

    /**
     * @throws LaravelODataException
     */
    public function __construct(ODataClientContract $client)
    {
      $this->client = $client;

      $this->entity = null;

      $this->expand = new Expand();

      $this->finder = new Finder();

      $this->filter = new Filter();

      $this->format = new Format($this->client->getResponseFormat());

      $this->grammar = new Grammar;

      $this->order_by = new OrderBy;

      $this->select = new Select;

      $this->slice_first = null;

      $this->slice_last = null;

      $this->skip = new Skip;

      $this->top = new Top;

      $this
        ->bind(QueryOption::TOP())
        ->bind(QueryOption::FORMAT());
    }

    /**
     * @param int|string|Closure $identifier Идентификатор
     * @return string
     * @throws LaravelODataException
     */
    public function find(int|string|Closure $identifier): string
    {
      if (!$this->entity) {
        throw new LaravelODataException('Entity is not initialized');
      }

      if ($identifier instanceof Closure) {
        $identifier($this->finder);
      } else {
        $this->finder->setId($identifier);
      }

      $this->bind(Root::FINDER());

      return $this->get();
    }

    /**
     * Установить главную сущность
     *
     * Начинается построение запроса
     *
     * @param ODataEntity $entity Сущность
     * @return QueryBuilder
     */
    public function from(ODataEntity $entity): QueryBuilder
    {
      $this->entity = $entity;

      return $this;
    }

    /**
     * Получить главную сущность
     *
     * @return ODataEntity|null
     */
    #[Pure]
    public function getEntity(): ?ODataEntity
    {
      return $this->entity;
    }

    /**
     * Коллекция раскрываемых сущностей
     *
     * @return ODataCollectionContract
     * @see QueryOption::EXPAND
     */
    #[Pure]
    public function getExpands(): ODataCollectionContract
    {
      return $this->expand->expands();
    }

    /**
     * Коллекция фильтров
     *
     * @return ODataCollectionContract
     * @see QueryOption::FILTER
     */
    #[Pure]
    public function getFilters(): ODataCollectionContract
    {
      return $this->filter->filters();
    }

    /**
     * Формат ответа OData
     *
     * @return Format
     * @see QueryOption::FORMAT
     */
    #[Pure]
    public function getFormat(): Format
    {
      return $this->format;
    }

    /**
     * Коллекция свойств(полей)
     *
     * @return ODataCollectionContract
     * @see QueryOption::SELECT
     */
    #[Pure]
    public function getSelects(): ODataCollectionContract
    {
      return $this->select->selects();
    }

    /**
     * @return Top
     */
    #[Pure]
    public function getTop(): Top
    {
      return $this->top;
    }

    /**
     * Количество записей
     *
     * @return $this
     */
    public function count(): QueryBuilder
    {
      $this->count = '/$' . QueryOption::COUNT();

      return $this;
    }

    /**
     * Раскрыть(урезанный JOIN)
     *
     * @param string|array|Closure $expand Наименование(я) раскрываемого(ых) свойств(а) или замыкание
     * @return QueryBuilder
     * @throws LaravelODataException|ValueObjectsException
     * @see QueryOption::EXPAND
     */
    public function expand(string|array|Closure $expand): QueryBuilder
    {
      if ($expand instanceof Closure) {
        $expand($this->expand);
      } else {
        $values = is_array($expand)
          ? $expand
          : func_get_args();

        foreach ($values as $v) {
          $this->expand->add($v);
        }
      }

      return $this->bind(QueryOption::EXPAND());
    }

    /**
     * Добавить фильтр
     *
     * Соединяется логическим оператором И
     *
     * @param string $field Свойство(поле)
     * @param string $operator Оператор
     * @param int|string $value Значение
     * @return QueryBuilder
     * @throws LaravelODataException|ValueObjectsException
     * @see QueryOption::FILTER
     */
    public function filter(string $field, string $operator, int|string $value): QueryBuilder
    {
      $this->filter->add($field, $operator, $value);

      return $this->bind(QueryOption::FILTER());
    }

    /**
     * Добавить фильтр(ы)
     *
     * В замыкании доступен экземпляр класса Filter
     *
     * @param Closure $callable Замыкание
     * @return QueryBuilder
     * @throws LaravelODataException
     * @see QueryOption::FILTER
     */
    public function filters(Closure $callable): QueryBuilder
    {
      $callable($this->filter);

      return $this->bind(QueryOption::FILTER());
    }

    /**
     * Добавить фильтр
     *
     * Соединяется логическим оператором ИЛИ
     *
     * @param string $field Свойство(поле)
     * @param string $operator Оператор
     * @param int|string $value Значение
     * @return QueryBuilder
     * @throws LaravelODataException|ValueObjectsException
     * @see QueryOption::FILTER
     */
    public function orFilter(string $field, string $operator, int|string $value): QueryBuilder
    {
      $this->filter->orAdd($field, $operator, $value);

      return $this->bind(QueryOption::FILTER());
    }

    /**
     * Добавить порядок выборки
     *
     * @throws ValueObjectsException
     * @throws LaravelODataException
     */
    public function order(string $field, ?EnumOrderBy $order = null): QueryBuilder
    {
      $this->order_by->addOrder($field, $order ?? EnumOrderBy::ASC());

      return $this->bind(Root::ORDER_BY());
    }

    /**
     *Добавить порядки выборки
     *
     * @throws LaravelODataException
     */
    public function orders(Closure $callback): QueryBuilder
    {
      $callback($this->order_by);

      return $this->bind(Root::ORDER_BY());
    }

    /**
     * Выбор свойств(полей)
     *
     * В замыкании доступен Экземпляр класса Select
     *
     * @param string|array|Closure $select Наименование(я) свойства(в) или замыкание
     * @return QueryBuilder
     * @throws LaravelODataException|ValueObjectsException
     * @see QueryOption::SELECT
     */
    public function select(string|array|Closure $select): QueryBuilder
    {
      if ($select instanceof Closure) {
        $select($this->select);
      } else {
        $values = is_array($select)
          ? $select
          : func_get_args();

        foreach ($values as $v) {
          $this->select->add($v);
        }
      }

      return $this->bind(QueryOption::SELECT());
    }

    /**
     * Добавить область
     *
     * Соединяется логическим оператором И
     *
     * @param Closure $callable Замыкание
     * @return QueryBuilder
     */
    public function scope(Closure $callable): QueryBuilder
    {
      $this->filter->scope($callable);

      return $this;
    }

    /**
     * Добавить область
     *
     * Соединяется логическим оператором ИЛИ
     *
     * @param Closure $callable Замыкание
     * @return QueryBuilder
     */
    public function orScope(Closure $callable): QueryBuilder
    {
      $this->filter->orScope($callable);

      return $this;
    }

    /**
     * Срез первых
     *
     * @param Closure|null $closure Замыкание
     * @return QueryBuilder
     */
    public function sliceFirst(?Closure $closure = null): QueryBuilder
    {
      $this->slice_first = new Slice(QueryOption::SLICE_FIRST());

      if ($closure) {
        $closure($this->slice_first);
      }

      return $this;
    }

    /**
     * Срез последних
     *
     * @param Closure|null $closure Замыкание
     * @return QueryBuilder
     */
    public function sliceLast(?Closure $closure = null): QueryBuilder
    {
      $this->slice_last = new Slice(QueryOption::SLICE_LAST());

      if ($closure) {
        $closure($this->slice_last);
      }

      return $this;
    }

    /**
     * Пропустить записи
     *
     * @param int $quantity Количество записей
     * @return $this
     * @throws LaravelODataException
     */
    public function skip(int $quantity): QueryBuilder
    {
      $this->skip->skip($quantity);

      return $this->bind(QueryOption::SKIP());
    }

    /**
     * Требуемое количество записей
     *
     * @param int $quantity Количество записей
     * @return $this
     */
    public function take(int $quantity): QueryBuilder
    {
      $this->top->take($quantity);

      return $this;
    }

    /**
     * Все записи
     *
     * Удалит из параметр запроса $top
     *
     * @return $this
     */
    public function takeAll(): QueryBuilder
    {
      foreach ($this->bind_query_options as $key => $qo) {
        if ($qo instanceof $this->top) {
          unset($this->bind_query_options[$key]);

          break;
        }
      }

      $this->top->setDefault();

      return $this;
    }

    /**
     * @param HTTPMethod $method Метод
     * @param mixed|null $payload Полезная нагрузка(Данные)
     * @return ResponseInterface
     * @throws LaravelODataException
     * @see ODataClientContract::request()
     */
    public function request(HttpMethod $method, mixed $payload = null): ResponseInterface
    {
      $uri = $this->getRequestUri();

      return $this->client->request($method, $uri, $payload);
    }

    /**
     * @return string
     * @see ODataClientContract::get()
     */
    public function get(): string
    {
      $uri = $this->getRequestUri();

      return $this->client->get($uri);
    }

    /**
     * @param QueryOption|Root $property Свойство
     * @return QueryBuilder
     * @throws LaravelODataException
     */
    private function bind(QueryOption|Root $property): QueryBuilder
    {
      if (!property_exists($this, $property)) {
        throw new LaravelODataException("Invalidate property $property. Property does not exist");
      }

      if (!in_array($this->{$property}, $this->bind_query_options, true)) {
        $this->bind_query_options[] = $this->{$property};
      }

      return $this;
    }

    /**
     * @return string
     */
    #[Pure]
    private function getSlice(): string
    {
      if ($this->{ROOT::SLICE_LAST()}) {
        return $this->{ROOT::SLICE_LAST()}->toQuery();
      }

      return $this->{ROOT::SLICE_FIRST()}?->toQuery() ?? '';
    }

    /**
     * @return string
     */
    #[Pure]
    private function getServiceRootUrl(): string
    {
      return $this->client->getBaseUrl()->value;
    }

    /**
     * @return string
     */
    private function getResourcePath(): string
    {
      $entity = $this
        ->getEntity()
        ->value;

      $finder = $this
        ->finder
        ->toQuery();

      $slice = $this->getSlice();

      $count = $this->count ?? '';

      return $this->grammar->encode($entity . $finder . $slice . $count);
    }

    /**
     * @return string
     */
    #[Pure]
    private function getQueryOptions(): string
    {
      $query_options = '';

      foreach ($this->bind_query_options as $query_option) {
        $qo = $query_option->toQuery();

        if (strlen($qo)) {
          $query_options .= $qo . '&';
        }
      }

      $query_options = rtrim($query_options, '&');

      return strlen($query_options)
        ? '?' . $query_options
        : $query_options;
    }

    /**
     * @link http://docs.oasis-open.org/odata/odata/v4.0/errata02/os/complete/part2-url-conventions/odata-v4.0-errata02-os-part2-url-conventions-complete.html#_Toc406398071
     */
    private function getRequestUri(): string
    {
      return
        $this->getServiceRootUrl() .
        $this->getResourcePath() .
        $this->getQueryOptions();
    }
  }
