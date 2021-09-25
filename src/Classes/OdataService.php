<?php

  namespace Doox911Opensource\LaravelOData\Classes;

  use Webmozart\Assert\Assert;
  use Doox911Opensource\LaravelOData\Classes\Enums\Auth;
  use Doox911Opensource\LaravelOData\Classes\Core\ODataClient;
  use Doox911Opensource\LaravelOData\Classes\Enums\ContentType;
  use Doox911Opensource\LaravelOData\Classes\Enums\ResponseFormat;
  use Doox911Opensource\LaravelOData\Contracts\ODataClientContract;
  use Doox911Opensource\ValueObjects\Exceptions\ValueObjectsException;
  use Doox911Opensource\LaravelOData\Exceptions\LaravelODataException;

  final class OdataService
  {
    protected ODataClientContract $client;

    /**
     * @throws ValueObjectsException
     */
    public function __construct(string $base_url, array $options)
    {
      Assert::StringNotEmpty(
        $base_url,
        'base_url must be not empty string'
      );

      $this->client = $this->createClient($base_url, $options);
    }

    /**
     * Начало работы с сервисом
     *
     * @throws ValueObjectsException
     * @throws LaravelODataException
     */
    public function from(string $entity): Core\QueryBuilder
    {
      return $this->client->from($entity);
    }

    /**
     * @throws ValueObjectsException
     */
    private function createClient(string $base_url, array $options): ODataClientContract
    {
      $auth = $options['auth'] ?? Auth::NO_AUTH();

      $content_type = $options['content_type'] ?? ContentType::APPLICATION_JSON();

      $response_format = $options['response_format'] ?? ResponseFormat::JSON();

      return new OdataClient(
        $base_url,
        $auth,
        $content_type,
        $response_format
      );
    }
  }
