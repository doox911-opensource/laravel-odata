<?php

  namespace Doox911Opensource\LaravelOData\Classes\Core;

  use function rtrim;
  use Psr\Http\Message\ResponseInterface;
  use Doox911Opensource\LaravelOData\Classes\Enums\Auth;
  use Doox911Opensource\LaravelOData\Classes\Enums\HTTPMethod;
  use Doox911Opensource\LaravelOData\Classes\Enums\ContentType;
  use Doox911Opensource\LaravelOData\Classes\Enums\ResponseFormat;
  use Doox911Opensource\LaravelOData\Classes\ValueObjects\ODataURL;
  use Doox911Opensource\LaravelOData\Contracts\ODataClientContract;
  use Doox911Opensource\LaravelOData\Contracts\ODataRequestContract;
  use Doox911Opensource\LaravelOData\Classes\ValueObjects\ODataEntity;
  use Doox911Opensource\ValueObjects\Exceptions\ValueObjectsException;
  use Doox911Opensource\LaravelOData\Exceptions\LaravelODataException;

  class ODataClient implements ODataClientContract
  {

    /**
     * Адрес интерфейса OData
     *
     * Базовый адрес
     *
     * @example https://services.odata.org/V4/TripPinService/
     */
    private ODataURL $base_url;

    /**
     * Формат ответа
     */
    private ContentType $content_type;

    /**
     * Формат ответа
     */
    private ResponseFormat $response_format;

    /**
     * HTTP клиент
     */
    private ODataRequestContract $client;

    /**
     * Клиент
     *
     * @param string $base_url Адрес интерфейса OData
     * @param ?ContentType $content_type Тип контента
     * @param ?ResponseFormat $response_format Формат ответа Odata
     * @throws ValueObjectsException
     */
    public function __construct(
      string $base_url,
      private ?Auth $auth = null,
      ?ContentType $content_type = null,
      ?ResponseFormat $response_format = null,
    )
    {
      $this
        ->setBaseUrl($base_url)
        ->setContentType($content_type ?? ContentType::APPLICATION_JSON())
        ->setResponseFormat($response_format ?? ResponseFormat::JSON());

      if (!$auth) {
        $this->auth = Auth::NO_AUTH();
      }

      $this->client = new ODataRequest($this);
    }

    /**
     * Тип авторизации
     *
     * @return string
     */
    public function getAuth(): string
    {
      return $this->auth;
    }

    /**
     * Адрес сервиса OData
     *
     * Включает в себя:
     * * Схему
     * * Authority
     * * Часть Path. К Path добавляется Entity.
     *
     * @return ODataURL
     */
    public function getBaseUrl(): ODataURL
    {
      return $this->base_url;
    }

    /**
     * Формат ответа
     *
     * @return ContentType
     */
    public function getContentType(): ContentType
    {
      return $this->content_type;
    }

    /**
     * Установить формат ответа сервера
     *
     * @param ContentType $type Формат
     * @return ODataClientContract
     */
    public function setContentType(ContentType $type): ODataClientContract
    {
      $this->content_type = $type;

      return $this;
    }

    /**
     * Формат ответа OData
     *
     * @return ResponseFormat
     */
    public function getResponseFormat(): ResponseFormat
    {
      return $this->response_format;
    }

    /**
     * Установить формат ответа OData
     *
     * Имеет приоритет перед ContentType
     *
     * @param ResponseFormat $type Формат
     * @return ODataClientContract
     */
    public function setResponseFormat(ResponseFormat $type): ODataClientContract
    {
      $this->response_format = $type;

      return $this;
    }

    /**
     * Начать работу с интерфейсом OData
     *
     * Установить сущность OData
     *
     * @param string $entity Сущность
     * @return QueryBuilder
     * @throws ValueObjectsException|LaravelODataException
     */
    public function from(string $entity): QueryBuilder
    {
      return $this->query()->from(new ODataEntity([
        'value' => $entity,
      ]));
    }

    /**
     * Начать работу с интерфейсом OData
     *
     * Получить нового построителя запроса
     *
     * @return QueryBuilder
     * @throws LaravelODataException
     */
    public function query(): QueryBuilder
    {
      return new QueryBuilder($this);
    }

    /**
     * Выполнить GET-запрос
     *
     * @param string $request_uri Унифицированный идентификатор ресурса
     * @return string
     * @throws LaravelODataException
     * @see ODataClientContract::get
     */
    public function get(string $request_uri): string
    {
      return $this
        ->request(HttpMethod::GET(), $request_uri)
        ->getBody()
        ->getContents();
    }

    /**
     * @param HTTPMethod $method Метод
     * @param string $request_uri Унифицированный идентификатор ресурса
     * @param mixed|null $payload Полезная нагрузка(Данные)
     * @return ResponseInterface
     * @throws LaravelODataException
     * @see ODataClientContract::request
     */
    public function request(HttpMethod $method, string $request_uri, mixed $payload = null): ResponseInterface
    {
      return $this
        ->client
        ->request($method, $request_uri, $payload);
    }

    /**
     * Установить адрес интерфейса OData
     *
     * @param string $base_url
     * @return ODataClientContract
     * @throws ValueObjectsException
     */
    private function setBaseUrl(string $base_url): ODataClientContract
    {
      $this->base_url = new ODataURL([
        'value' => rtrim($base_url, '/') . '/'
      ]);

      return $this;
    }
  }
