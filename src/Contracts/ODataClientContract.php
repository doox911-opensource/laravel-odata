<?php

  namespace Doox911Opensource\LaravelOData\Contracts;

  use Psr\Http\Message\ResponseInterface;
  use Doox911Opensource\LaravelOData\Classes\Enums\HTTPMethod;
  use Doox911Opensource\LaravelOData\Exceptions\LaravelODataException;

  interface ODataClientContract
  {

    /**
     * Запрос
     *
     * @param HTTPMethod $method Метод
     * @param string $request_uri Унифицированный идентификатор ресурса
     * @param mixed|null $payload Полезная нагрузка(Данные)
     * @return ResponseInterface
     * @throws LaravelODataException
     * @see ODataClientContract::request
     */
    public function request(HttpMethod $method, string $request_uri, mixed $payload = null): ResponseInterface;

    /**
     * Get-запрос
     *
     * @param string $request_uri
     * @return string
     */
    public function get(string $request_uri): string;

  }
