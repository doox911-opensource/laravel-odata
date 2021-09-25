<?php

  namespace Doox911Opensource\LaravelOData\Tests\Classes\Core\Instances;

  use Doox911Opensource\LaravelOData\Classes\Enums\Auth;
  use Doox911Opensource\LaravelOData\Classes\Core\Filter;
  use Doox911Opensource\LaravelOData\Classes\Core\Select;
  use Doox911Opensource\LaravelOData\Classes\Core\ODataClient;
  use Doox911Opensource\LaravelOData\Classes\Enums\ContentType;
  use Doox911Opensource\LaravelOData\Classes\Core\QueryBuilder;
  use Doox911Opensource\LaravelOData\Classes\Enums\ResponseFormat;
  use Doox911Opensource\LaravelOData\Contracts\ODataClientContract;
  use Doox911Opensource\LaravelOData\Exceptions\LaravelODataException;
  use Doox911Opensource\LaravelOData\Classes\ValueObjects\ODataEntity;
  use Doox911Opensource\ValueObjects\Exceptions\ValueObjectsException;

  final class QueryBuilderInstance
  {

    /**
     * @throws ValueObjectsException|LaravelODataException
     */
    public static function new(?Auth $auth = null, ?ContentType $content_type = null, ?ResponseFormat $response_format = null): QueryBuilder
    {
      $odata_client = self::getOdataClient(
        $auth,
        $content_type ?? ContentType::APPLICATION_JSON(),
        $response_format ?? ResponseFormat::JSON(),
      );

      return new QueryBuilder($odata_client);
    }

    /**
     * @throws ValueObjectsException|LaravelODataException
     */
    public static function from(string $entity): QueryBuilder
    {
      $builder = self::new();

      $odata_entity = self::getOdataEntity($entity);

      return $builder->from($odata_entity);
    }

    /**
     * @throws LaravelODataException|ValueObjectsException
     */
    public static function addFilter(string $field, string $operator, string $value): QueryBuilder
    {
      $builder = self::new();

      return $builder->filters(fn(Filter $filter) => $filter->add($field, $operator, $value));
    }

    /**
     * @throws LaravelODataException|ValueObjectsException
     */
    public static function addSelect(string $field): QueryBuilder
    {
      $builder = self::new();

      return $builder->select(fn(Select $select) => $select->add($field));
    }

    /**
     * @throws ValueObjectsException
     */
    protected static function getOdataEntity(string $string): ODataEntity
    {
      return new ODataEntity([
        'value' => $string,
      ]);
    }

    /**
     * @throws ValueObjectsException
     */
    protected static function getOdataClient(?Auth $auth = null, ?ContentType $content_type = null, ?ResponseFormat $response_format = null): ODataClientContract
    {
      return new ODataClient(
        config('laravel-odata.test.query_builder.base_url'),
        $auth,
        $content_type,
        $response_format
      );
    }
  }
