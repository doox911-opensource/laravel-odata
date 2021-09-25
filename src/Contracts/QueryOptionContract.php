<?php

  namespace Doox911Opensource\LaravelOData\Contracts;

  interface QueryOptionContract
  {

    /**
     * Представление в параметр запроса
     *
     * @return string
     */
    public function toQuery(): string;
  }
