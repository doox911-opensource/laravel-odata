<?php

  namespace Doox911Opensource\LaravelOData\Classes\Collections;

  use Doox911Opensource\LaravelOData\Classes\Core\Scope;
  use Doox911Opensource\LaravelOData\Traits\ValidateType;

  final class ODataScopeCollection extends ODataCollection
  {

    use ValidateType;

    public function __construct(...$items)
    {
      $this->type = Scope::class;

      parent::__construct(...$items);
    }
  }
