<?php

  namespace Doox911Opensource\LaravelOData\Classes\ValueObjects;

  use JetBrains\PhpStorm\Immutable;
  use Doox911Opensource\LaravelOData\Classes\Enums\LogicalOperator;
  use Doox911Opensource\LaravelOData\Attributes\StringNotEmpty;
  use Doox911Opensource\ValueObjects\Classes\AbstractValueObject;

  /**
   * @property string $field
   * @property string $operator
   * @property string $connection_operator
   * @property string $value
   * @method string getField
   * @method string getOperator
   * @method string getConnectionOperator
   * @method string getValue
   */
  #[Immutable]
  class ODataFilter extends AbstractValueObject
  {

    /**
     * Поле
     */
    #[StringNotEmpty]
    protected string $field;

    /**
     * Оператор OData
     */
    #[StringNotEmpty]
    protected string $operator;

    /**
     * Оператор соединения
     */
    protected LogicalOperator $connection_operator;

    /**
     * Значение поля
     */
    #[StringNotEmpty]
    protected string $value;

    public function __toString()
    {
      return $this->field . ' ' . $this->operator . ' ' . $this->value;
    }
  }
