<?php

  namespace Doox911Opensource\LaravelOData\Classes\Enums;

  use MyCLabs\Enum\Enum;

  /**
   * Логические операторы
   *
   * @method static LogicalOperator AND
   * @method static LogicalOperator EQUALS
   * @method static LogicalOperator GREATER_THAN
   * @method static LogicalOperator GREATER_THAN_OR_EQUAL
   * @method static LogicalOperator HAS
   * @method static LogicalOperator LESS_THAN
   * @method static LogicalOperator LESS_THAN_OR_EQUAL
   * @method static LogicalOperator NOT
   * @method static LogicalOperator NOT_EQUALS
   * @method static LogicalOperator OR
   */
  class LogicalOperator extends Enum
  {

    /**
     * И
     *
     * Оператор and возвращает значение true, если и левый, и правый операнды имеют значение true, в противном случае он возвращает false.
     * Null значение трактуется как неизвестность, поэтому, если один из операндов имеет значение null, а другой операнд ложь, and возвращает ложь.
     * Все другие комбинации с null значением возвращают null значение.
     *
     * @link http://docs.oasis-open.org/odata/odata/v4.0/errata02/os/complete/part2-url-conventions/odata-v4.0-errata02-os-part2-url-conventions-complete.html#_Toc406398102
     */
    private const AND = 'and';

    /**
     * Равно
     *
     * Оператор eq возвращает истину, если левый операнд равен правому операнду, в противном случае возвращает ложь.
     * Null значение равно самому себе, и только себе.
     *
     * @link http://docs.oasis-open.org/odata/odata/v4.0/errata02/os/complete/part2-url-conventions/odata-v4.0-errata02-os-part2-url-conventions-complete.html#_Toc406398096
     */
    private const EQUALS = 'eq';

    /**
     * Больше чем
     *
     * Оператор gt возвращает истину, если левый операнд больше правого операнда, в противном случае он возвращает ложь.
     * Если какой-либо операнд имеет значение null, оператор возвращает false.
     * Для логических значений истина больше, чем ложь.
     *
     * @link http://docs.oasis-open.org/odata/odata/v4.0/errata02/os/complete/part2-url-conventions/odata-v4.0-errata02-os-part2-url-conventions-complete.html#_Toc406398098
     */
    private const GREATER_THAN = 'gt';

    /**
     * Больше или равно
     *
     * Оператор ge возвращает true, если левый операнд больше или равен правому операнду, в противном случае он возвращает false.
     * Если только один операнд имеет значение NULL, оператор возвращает значение false.
     * Если оба операнда равны null, он возвращает истину, потому что null равен самому себе.
     *
     * @link http://docs.oasis-open.org/odata/odata/v4.0/errata02/os/complete/part2-url-conventions/odata-v4.0-errata02-os-part2-url-conventions-complete.html#_Toc406398099
     */
    private const GREATER_THAN_OR_EQUAL = 'ge';

    /**
     * Имеет
     *
     * Оператор has возвращает истину, если правый операнд является значением перечисления, флаг(и) которого установлен на левом операнде.
     * Null значение рассматривается как неизвестное, так что если один операнд имеет значение NULL, has возвращает null.
     *
     * @link http://docs.oasis-open.org/odata/odata/v4.0/errata02/os/complete/part2-url-conventions/odata-v4.0-errata02-os-part2-url-conventions-complete.html#_Toc406398105
     */
    private const HAS = 'has';

    /**
     * Меньше чем
     *
     * Оператор lt возвращает истину, если левый операнд меньше правого операнда, в противном случае он возвращает ложь.
     * Если какой-либо операнд имеет значение null, оператор возвращает false.
     *
     * @link http://docs.oasis-open.org/odata/odata/v4.0/errata02/os/complete/part2-url-conventions/odata-v4.0-errata02-os-part2-url-conventions-complete.html#_Toc406398100
     */
    private const LESS_THAN = 'lt';

    /**
     * Меньше или равно
     *
     * Оператор le возвращает истину, если левый операнд меньше или равен правому операнду, в противном случае он возвращает ложь.
     * Если только один операнд имеет значение NULL, оператор возвращает значение false.
     * Если оба операнда равны null, он возвращает истину, потому что null равен самому себе.
     *
     * @link http://docs.oasis-open.org/odata/odata/v4.0/errata02/os/complete/part2-url-conventions/odata-v4.0-errata02-os-part2-url-conventions-complete.html#_Toc406398101
     */
    private const LESS_THAN_OR_EQUAL = 'le';

    /**
     * Не
     *
     * Оператор not возвращает true, если операнд возвращает false, в противном случае возвращает false.
     * Null значение трактуется как неизвестность, поэтому not null вернёт null.
     *
     * @link http://docs.oasis-open.org/odata/odata/v4.0/errata02/os/complete/part2-url-conventions/odata-v4.0-errata02-os-part2-url-conventions-complete.html#_Toc406398104
     */
    private const NOT = 'not';

    /**
     * Не равно
     *
     * Оператор ne возвращает true, если левый операнд не равен правому операнду, в противном случае он возвращает false.
     * Null значение не равно ни одному значению, но сам по себе.
     *
     * @link http://docs.oasis-open.org/odata/odata/v4.0/errata02/os/complete/part2-url-conventions/odata-v4.0-errata02-os-part2-url-conventions-complete.html#_Toc406398097
     */
    private const NOT_EQUALS = 'ne';

    /**
     * Или
     *
     * Оператор or возвращает false, если оба операнда имеют значение false, в противном случае он возвращает true.
     * Null значение рассматривается как неизвестное, так что если один из операндов имеет значение Null, а другой операнд - истина, or возвращает значение ИСТИНА.
     * Все другие комбинации с нулевым значением возвращают нулевое значение .
     *
     * @link http://docs.oasis-open.org/odata/odata/v4.0/errata02/os/complete/part2-url-conventions/odata-v4.0-errata02-os-part2-url-conventions-complete.html#_Toc406398103
     */
    private const OR = 'or';

  }
