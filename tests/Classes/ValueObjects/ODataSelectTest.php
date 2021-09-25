<?php

  namespace Doox911Opensource\LaravelOData\Tests\Classes\ValueObjects;

  use Orchestra\Testbench\TestCase;
  use Doox911Opensource\ValueObjects\Exceptions\ValueObjectsException;
  use Doox911Opensource\LaravelOData\Tests\Classes\ValueObjects\Instances\ODataSelectInstance;

  class ODataSelectTest extends TestCase
  {

    /**
     * В массив
     *
     * @throws ValueObjectsException
     */
    public function testToArrayAndToToArrayFromStore()
    {
      $string = 'ХарактеристикаНоменклатуры/Description';

      $select = ODataSelectInstance::new($string);

      $select_array = [
        'value' => $string,
      ];

      $this->assertSame($select_array, $select->toArray());
      $this->assertSame($select_array, $select->toArrayFromStore());
    }

    /**
     * В строку
     *
     * @throws ValueObjectsException
     */
    public function test__ToString()
    {
      $string = 'ХарактеристикаНоменклатуры/Description';

      $select = (string)ODataSelectInstance::new($string);

      $this->assertSame($string, $select);
    }
  }
