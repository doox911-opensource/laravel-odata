<?php

  namespace Doox911Opensource\LaravelOData\Classes\Core;

  use function count;
  use function implode;
  use function in_array;
  use function is_string;
  use function mb_str_split;
  use function rawurldecode;
  use function rawurlencode;
  use Doox911Opensource\LaravelOData\Contracts\GrammarContract;
  use JetBrains\PhpStorm\Pure;

  final class Grammar implements GrammarContract
  {

    /**
     * Не кодируемые символы
     *
     * @link https://datatracker.ietf.org/doc/html/rfc3986#section-2.2
     */
    private const NO_ENCODE_SYMBOLS = [
      ':',
      '/',
      '?',
      '#',
      '[',
      ']',
      '@',
      '!',
      '$',
      '&',
      '\'',
      '(',
      ')',
      '*',
      '+',
      ',',
      ';',
      '=',
    ];

    /**
     * Закодировать строку
     *
     * @param string $string Строка
     * @param bool $force Кодировать строку и не кодируемые символы
     * @return string
     */
    public function encode(string $string, bool $force = false): string
    {
      if ($force) {
        return rawurlencode($string);
      }

      $array = mb_str_split($string);

      $length = count($array);

      for ($i = 0; $i < $length; $i++) {
        if (!in_array($array[$i], Grammar::NO_ENCODE_SYMBOLS)) {
          $array[$i] = rawurlencode($array[$i]);
        }
      }

      return implode($array);
    }

    /**
     * Декодировать строку
     *
     * @param string $string Строка
     * @return string
     */
    public function decode(string $string): string
    {
      return rawurldecode($string);
    }

    /**
     * Добавить кавычки
     *
     * @param string $string
     * @return string
     */
    public function addQuotes(string $string): string
    {
      return '\'' . $string . '\'';
    }

    /**
     * Подготовка значения
     *
     * В запросах к OData строковое значение передаются в одинарных кавычках
     */
    #[Pure]
    public function prepareODataValue(int|string $value): int|string
    {
      if (is_string($value)) {
        $value = trim($value, '\'\"');

        $value = $this->addQuotes($value);
      }

      return $value;
    }
  }
