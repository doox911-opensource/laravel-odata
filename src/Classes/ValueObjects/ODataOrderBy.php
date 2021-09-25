<?php

  namespace Doox911Opensource\LaravelOData\Classes\ValueObjects;

  use JetBrains\PhpStorm\Immutable;
  use Doox911Opensource\LaravelOData\Classes\Enums\OrderBy;
  use Doox911Opensource\LaravelOData\Attributes\StringNotEmpty;
  use Doox911Opensource\ValueObjects\Classes\AbstractValueObject;

  /**
   * @property string $field
   * @property string $order
   * @method string getField
   * @method string getOrder
   * @method string toArray
   */
  #[Immutable]
  class ODataOrderBy extends AbstractValueObject
  {
    #[StringNotEmpty]
    protected string $field;

    protected OrderBy $order;

    public function __toString()
    {
      return $this->field . ' ' . $this->order;
    }
  }
