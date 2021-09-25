<?php

  namespace Doox911Opensource\LaravelOData\Classes\Enums;

  use MyCLabs\Enum\Enum;

  /**
   * Имена свойств
   *
   * @method static Root FINDER
   * @method static Root ORDER_BY
   * @method static Root RECORD_TYPE
   * @method static Root ROW_TYPE
   * @method static Root SLICE_FIRST
   * @method static Root SLICE_LAST
   */
  class Root extends Enum
  {

    private const FINDER = 'finder';

    private const ORDER_BY = 'order_by';

    private const RECORD_TYPE = 'record_type';

    private const ROW_TYPE = 'row_type';

    private const SLICE_FIRST = 'slice_first';

    private const SLICE_LAST = 'slice_last';

  }
