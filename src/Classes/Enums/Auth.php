<?php

  namespace Doox911Opensource\LaravelOData\Classes\Enums;

  use MyCLabs\Enum\Enum;

  /**
   * @method static Auth NO_AUTH
   * @method static Auth BASIC
   * @method static Auth DIGEST
   */
  class Auth extends Enum
  {
    private const NO_AUTH = 'no_auth';

    private const BASIC = 'basic';

    private const DIGEST = 'digest';
  }
