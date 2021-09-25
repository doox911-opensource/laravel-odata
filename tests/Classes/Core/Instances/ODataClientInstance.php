<?php

  namespace Doox911Opensource\LaravelOData\Tests\Classes\Core\Instances;

  use Doox911Opensource\LaravelOData\Classes\Enums\Auth;
  use Doox911Opensource\LaravelOData\Classes\Core\ODataClient;
  use Doox911Opensource\LaravelOData\Classes\Enums\ContentType;
  use Doox911Opensource\LaravelOData\Classes\Enums\ResponseFormat;
  use Doox911Opensource\LaravelOData\Contracts\ODataClientContract;
  use Doox911Opensource\ValueObjects\Exceptions\ValueObjectsException;

  final class ODataClientInstance
  {

    /**
     * @throws ValueObjectsException
     */
    public static function new(?Auth $auth = null, ?ContentType $content_type = null, ?ResponseFormat $response_format = null): ODataClientContract
    {
      return new ODataClient(
        config('laravel-odata.test.client.base_url'),
        $auth,
        $content_type,
        $response_format
      );
    }
  }
