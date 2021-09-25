<?php

  namespace Doox911Opensource\LaravelOData\Classes\Enums;

  use MyCLabs\Enum\Enum;

  /**
   * Формат данных в ответе OData
   *
   * @method static Operator JSON
   * @method static Operator XML
   */
  class ResponseFormat extends Enum
  {
    private const JSON = 'json';

    private const XML = 'xml';
  }
