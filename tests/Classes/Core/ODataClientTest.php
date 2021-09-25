<?php

  namespace Doox911Opensource\LaravelOData\Tests\Classes\Core;

  use Orchestra\Testbench\TestCase;
  use Illuminate\Foundation\Application;
  use Doox911Opensource\LaravelOData\Classes\Enums\Auth;
  use Doox911Opensource\LaravelOData\Classes\Enums\HTTPMethod;
  use Doox911Opensource\LaravelOData\Exceptions\LaravelODataException;
  use Doox911Opensource\ValueObjects\Exceptions\ValueObjectsException;
  use Doox911Opensource\LaravelOData\Providers\LaravelODataServiceProvider;
  use Doox911Opensource\LaravelOData\Tests\Classes\Core\Instances\ODataClientInstance;

  class ODataClientTest extends TestCase
  {

    /**
     * Get-запрос с Basic-авторизацией
     *
     * @throws ValueObjectsException
     * @throws LaravelODataException
     */
    public function testBasicGet()
    {
      $odata_client = ODataClientInstance::new(Auth::BASIC());

      $response = $odata_client
        ->from('InformationRegister_ЦеныНоменклатурыКонтрагентов_RecordType')
        ->sliceLast()
        ->take(5)
        ->request(HttpMethod::GET());

      $this->assertSame(200, $response->getStatusCode());
    }

    /**
     * @param Application $app
     * @return string[]
     */
    protected function getPackageProviders($app): array
    {
      return [
        LaravelODataServiceProvider::class,
      ];
    }
  }
