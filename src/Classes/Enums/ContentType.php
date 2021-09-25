<?php

  namespace Doox911Opensource\LaravelOData\Classes\Enums;

  use MyCLabs\Enum\Enum;

  /**
   * @method static Operator APPLICATION_JSON
   * @method static Operator APPLICATION_XML
   */
  class ContentType extends Enum
  {
    private const APPLICATION_JSON = 'application/json';

    private const APPLICATION_XML = 'application/xml';
  }
