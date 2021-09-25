<?php

  namespace Doox911Opensource\LaravelOData\Classes\Enums;

  use MyCLabs\Enum\Enum;

  /**
   * @method static Suffix FINDER
   */
  class Suffix extends Enum
  {

    /**
     * Сущность с таким суффиксом описывает отдельную запись регистра
     */
    private const RECORD_TYPE = 'RecordType';

    /**
     * Сущность с таким суффиксом описывает тип строки табличной части какого-либо объекта
     */
    private const ROW_TYPE = 'RowType';
  }
