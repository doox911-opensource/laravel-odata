<?php

  namespace Doox911Opensource\LaravelOData\Traits\Core;

  trait ToQuery
  {

    /**
     * Закодировать
     *
     * @return string
     */
    public function encodeToString(): string
    {
      return $this
        ->grammar
        ->encode((string)$this);
    }

    /**
     * Получить закодированный префикс Odata параметра запроса
     *
     * @return string
     */
    public function getEncodeQueryPrefix(): string
    {
      return $this->grammar->encode($this->getQueryPrefix(), true);
    }

    /**
     * @return string
     * @see QueryOptionContract::toQuery
     */
    public function toQuery(): string
    {
      return $this->getEncodeQueryPrefix() . '=' . $this->encodeToString();
    }
  }
