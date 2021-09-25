<?php

  namespace Doox911Opensource\LaravelOData\Classes\Enums;

  use MyCLabs\Enum\Enum;

  /**
   * @method static HTTPMethod DELETE
   * @method static HTTPMethod GET
   * @method static HTTPMethod HEAD
   * @method static HTTPMethod OPTIONS
   * @method static HTTPMethod POST
   * @method static HTTPMethod PUT
   * @method static HTTPMethod PATCH
   * @method static HTTPMethod TRACE
   */
  class HTTPMethod extends Enum
  {

    /**
     * Метод протокола HTTP DELETE.
     */
    private const DELETE = 'DELETE';

    /**
     * Метод протокола HTTP GET.
     */
    private const GET = 'GET';

    /**
     * Метод протокола HTTP HEAD(Только заголовки)
     */
    private const HEAD = 'HEAD';

    /**
     * Метод протокола HTTP OPTIONS.
     */
    private const OPTIONS = 'OPTIONS';

    /**
     * Метод протокола HTTP POST(Создание).
     */
    private const POST = 'POST';

    /**
     * Метод протокола HTTP PUT(Замена).
     */
    private const PUT = 'PUT';

    /**
     * Метод протокола HTTP PATCH(Обновление).
     */
    private const PATCH = 'PATCH';

    /**
     * Метод протокола HTTP TRACE.
     */
    private const TRACE = 'TRACE';
  }
