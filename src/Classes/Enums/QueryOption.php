<?php

  namespace Doox911Opensource\LaravelOData\Classes\Enums;

  use MyCLabs\Enum\Enum;

  /**
   * Параметр запроса (Системные параметры запроса)
   *
   * @method static QueryOption COUNT
   * @method static QueryOption EXPAND
   * @method static QueryOption FILTER
   * @method static QueryOption FORMAT
   * @method static QueryOption ORDER_BY
   * @method static QueryOption RECORD_TYPE
   * @method static QueryOption ROW_TYPE
   * @method static QueryOption SEARCH
   * @method static QueryOption SELECT
   * @method static QueryOption SKIP
   * @method static QueryOption SLICE_FIRST
   * @method static QueryOption SLICE_LAST
   * @method static QueryOption TOP
   */
  class QueryOption extends Enum
  {

    /**
     * Количество
     *
     * Параметр системного запроса $count позволяет клиентам запрашивать количество совпадающих ресурсов, включенных в ответ на ресурсы.
     * Параметр запроса $count имеет логическое значение true или false.
     *
     * @link http://docs.oasis-open.org/odata/odata/v4.0/errata02/os/complete/part2-url-conventions/odata-v4.0-errata02-os-part2-url-conventions-complete.html#_Toc406398166
     */
    private const COUNT = 'count';

    /**
     * Раскрыть (урезанный JOIN)
     *
     * Параметр системного запроса $expand указывает связанные ресурсы, которые должны быть включены в список извлеченных ресурсов.
     *
     * @link http://docs.oasis-open.org/odata/odata/v4.0/errata02/os/complete/part2-url-conventions/odata-v4.0-errata02-os-part2-url-conventions-complete.html#_Toc406398162
     */
    private const EXPAND = 'expand';

    /**
     * Фильтр
     *
     * Параметр системного запроса $filter позволяет клиентам фильтровать набор ресурсов, адресованных по URL-адресу запроса.
     * Выражение, указанное с помощью $filter, оценивается для каждого ресурса в коллекции, и в ответ включаются только те элементы, для которых значение выражения истинно.
     * Ресурсы, для которых выражение принимает значение false или null, или какие ссылочные свойства недоступны из-за разрешений, не включаются в ответ.
     *
     * @link http://docs.oasis-open.org/odata/odata/v4.0/errata02/os/complete/part2-url-conventions/odata-v4.0-errata02-os-part2-url-conventions-complete.html#_Toc406398094
     */
    private const FILTER = 'filter';

    /**
     * Формат
     *
     * Параметр системного запроса $format позволяет клиентам запрашивать ответ в определенном формате и полезен для клиентов,
     * не имеющих доступа к заголовкам запросов для стандартного согласования типа содержимого.
     * Где присутствует $format имеет приоритет над стандартным согласованием типа содержимого.
     *
     * @link http://docs.oasis-open.org/odata/odata/v4.0/errata02/os/complete/part2-url-conventions/odata-v4.0-errata02-os-part2-url-conventions-complete.html#_Toc406398169
     */
    private const FORMAT = 'format';

    /**
     * Порядок
     *
     * Параметр системного запроса $orderby позволяет клиентам запрашивать ресурсы в определенном порядке.
     *
     * @link http://docs.oasis-open.org/odata/odata/v4.0/errata02/os/complete/part2-url-conventions/odata-v4.0-errata02-os-part2-url-conventions-complete.html#_Toc406398164
     */
    private const ORDER_BY = 'orderby';

    private const RECORD_TYPE = 'RecordType';

    private const ROW_TYPE = 'RowType';

    /**
     * Поиск (Доступен с V4)
     *
     * Параметр запроса системы $search позволяет клиентам запрашивать объекты, соответствующие выражению поиска с произвольным текстом.
     *
     * @link http://docs.oasis-open.org/odata/odata/v4.0/errata02/os/complete/part2-url-conventions/odata-v4.0-errata02-os-part2-url-conventions-complete.html#_Toc406398167
     */
    private const SEARCH = 'search';

    /**
     * Выборка свойств
     *
     * Параметр системного запроса $select позволяет клиентам запрашивать определенный набор свойств для каждой сущности или сложного типа.
     * Параметр запроса $select часто используется вместе с параметром системного запроса $expand, чтобы определить экстент графа ресурсов, который нужно вернуть ($expand),
     * а затем указать подмножество свойств для каждого ресурса в графе ($select).
     * Свойства расширенной навигации ДОЛЖНЫ быть возвращены, даже если они не указаны как выбранное свойство.
     *
     * @link http://docs.oasis-open.org/odata/odata/v4.0/errata02/os/complete/part2-url-conventions/odata-v4.0-errata02-os-part2-url-conventions-complete.html#_Toc406398163
     */
    private const SELECT = 'select';

    /**
     * Количество элементов не включённых в результат
     *
     * Параметр запроса $skip запрашивает количество элементов в запрошенной коллекции, которые должны быть пропущены и не включены в результат
     *
     * @link http://docs.oasis-open.org/odata/odata/v4.0/errata02/os/complete/part2-url-conventions/odata-v4.0-errata02-os-part2-url-conventions-complete.html#_Toc406398165
     */
    private const SKIP = 'skip';

    /**
     * Срез первых
     */
    private const SLICE_FIRST = 'SliceFirst';

    /**
     * Срез последних
     */
    private const SLICE_LAST = 'SliceLast';

    /**
     * Количество элементов
     *
     * Параметр системного запроса $top запрашивает количество элементов в запрошенной коллекции, которые будут включены в результат.
     *
     * @link http://docs.oasis-open.org/odata/odata/v4.0/errata02/os/complete/part2-url-conventions/odata-v4.0-errata02-os-part2-url-conventions-complete.html#_Toc406398165
     */
    private const TOP = 'top';
  }


