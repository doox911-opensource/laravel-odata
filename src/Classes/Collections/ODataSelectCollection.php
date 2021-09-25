<?php

  namespace Doox911Opensource\LaravelOData\Classes\Collections;

  use Doox911Opensource\LaravelOData\Traits\ValidateType;
  use Doox911Opensource\LaravelOData\Classes\ValueObjects\ODataSelect;

  /**
   * @method array toArray
   */
  final class ODataSelectCollection extends ODataCollection
  {

    use ValidateType;

    public function __construct(...$items)
    {
      $this->type = ODataSelect::class;

      parent::__construct(...$items);
    }
  }
