<?php

  namespace Doox911Opensource\LaravelOData\Classes\Collections;

  use Doox911Opensource\LaravelOData\Traits\ValidateType;
  use Doox911Opensource\LaravelOData\Classes\ValueObjects\ODataFilter;

  final class ODataFilterCollection extends ODataCollection
  {

    use ValidateType;

    public function __construct(...$items)
    {
      $this->type = ODataFilter::class;

      parent::__construct(...$items);
    }
  }
