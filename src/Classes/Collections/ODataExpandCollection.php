<?php

  namespace Doox911Opensource\LaravelOData\Classes\Collections;

  use Doox911Opensource\LaravelOData\Traits\ValidateType;
  use Doox911Opensource\LaravelOData\Classes\ValueObjects\ODataExpand;

  final class ODataExpandCollection extends ODataCollection
  {

    use ValidateType;

    public function __construct(...$items)
    {
      $this->type = ODataExpand::class;

      parent::__construct(...$items);
    }
  }
