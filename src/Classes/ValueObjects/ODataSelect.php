<?php

  namespace Doox911Opensource\LaravelOData\Classes\ValueObjects;

  use JetBrains\PhpStorm\Immutable;
  use Doox911Opensource\LaravelOData\Attributes\StringNotEmpty;
  use Doox911Opensource\ValueObjects\Classes\AbstractValueObject;

  /**
   * @property string $value
   * @method string getValue
   */
  #[Immutable]
  class ODataSelect extends AbstractValueObject
  {
    #[StringNotEmpty]
    protected string $value;

    public function __toString()
    {
      return $this->value;
    }
  }
