<?php

  namespace Doox911Opensource\LaravelOData\Classes\Core;

  use GuzzleHttp\Client;
  use GuzzleHttp\Psr7\Request;
  use Psr\Http\Message\ResponseInterface;
  use GuzzleHttp\Exception\GuzzleException;
  use Doox911Opensource\LaravelOData\Classes\Enums\Auth;
  use Doox911Opensource\LaravelOData\Classes\Enums\HTTPMethod;
  use Doox911Opensource\LaravelOData\Classes\Enums\ContentType;
  use Doox911Opensource\LaravelOData\Classes\Enums\ResponseFormat;
  use Doox911Opensource\LaravelOData\Contracts\ODataRequestContract;
  use Doox911Opensource\LaravelOData\Exceptions\LaravelODataException;

  class ODataRequest implements ODataRequestContract
  {
    private Client $client;

    public function __construct(
      private OdataClient $odata_client
    )
    {
      $this->client = new Client();
    }

    /**
     * Запрос
     *
     * @param HTTPMethod $method HTTP Метод
     * @param string $request_uri URI
     * @param mixed|null $payload Полезные данные
     * @return ResponseInterface
     * @throws LaravelODataException
     */
    public function request(HTTPMethod $method, string $request_uri, mixed $payload = null): ResponseInterface
    {
      try {
        $request = $this->createRequest($method, $request_uri, $payload);

        return $this->send($request);
      } catch (GuzzleException $e) {
        $message = $this->isJSON()
          ? (json_decode($e->getResponse()->getBody()->getContents()))->{"odata.error"}->message->value
          : $e->getMessage();

        throw new LaravelODataException($message);
      }
    }

    /**
     * @param Request $request Запрос
     * @return ResponseInterface
     * @throws GuzzleException
     */
    private function send(Request $request): ResponseInterface
    {
      return match (true) {
        $this->odata_client->getAuth() == Auth::BASIC() => $this->sendBasic($request),
        $this->odata_client->getAuth() == Auth::DIGEST() => $this->sendDigest($request),
        default => $this->sendWithOutAuth($request)
      };
    }

    /**
     * @param Request $request Запрос
     * @return ResponseInterface
     * @throws GuzzleException
     */
    private function sendWithOutAuth(Request $request): ResponseInterface
    {
      return $this->client->send($request);
    }

    /**
     * @param Request $request Запрос
     * @return ResponseInterface
     * @throws GuzzleException
     */
    private function sendBasic(Request $request): ResponseInterface
    {
      return $this->client->send($request, [
        'auth' => [
          config('laravel-odata.authorization.basic.login'),
          config('laravel-odata.authorization.basic.password'),
        ],
      ]);
    }

    /**
     * @param Request $request Запрос
     * @return ResponseInterface
     * @throws GuzzleException
     */
    private function sendDigest(Request $request): ResponseInterface
    {
      return $this->client->send($request, [
        'auth' => [
          config('laravel-odata.authorization.digest.login'),
          config('laravel-odata.authorization.digest.password'),
          Auth::DIGEST(),
        ],
      ]);
    }

    /**
     * @param HTTPMethod $method HTTP Метод
     * @param string $request_uri URI
     * @param mixed|null $payload Полезные данные
     * @return Request
     */
    private function createRequest(HTTPMethod $method, string $request_uri, mixed $payload = null): Request
    {
      return new Request((string)$method, $request_uri);
    }

    private function isJSON(): bool
    {
      return $this->odata_client->getContentType() == ContentType::APPLICATION_JSON() ||
        $this->odata_client->getResponseFormat() == ResponseFormat::JSON();
    }
  }
