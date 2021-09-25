<?php

  namespace Doox911Opensource\LaravelOData\Classes\Enums;

  use MyCLabs\Enum\Enum;

  /**
   * @method static OrderBy ASC
   * @method static OrderBy DESC
   */
  class OrderBy extends Enum
  {
    private const ASC = 'asc';

    private const DESC = 'desc';
  }
