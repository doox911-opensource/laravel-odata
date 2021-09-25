<?php

  namespace Doox911Opensource\LaravelOData\Tests\Classes\ValueObjects;

  use Orchestra\Testbench\TestCase;
  use Doox911Opensource\ValueObjects\Exceptions\ValueObjectsException;
  use Doox911Opensource\LaravelOData\Tests\Classes\ValueObjects\Instances\ODataEntityInstance;

  class ODataEntityTest extends TestCase
  {

    /**
     * @throws ValueObjectsException
     */
    public function testToArrayAndToToArrayFromStore()
    {
      $entity = ODataEntityInstance::new('InformationRegister_ЦеныНоменклатурыКонтрагентов');

      $array_entity = [
        'value' => 'InformationRegister_ЦеныНоменклатурыКонтрагентов'
      ];

      $this->assertSame($array_entity, $entity->toArray());
      $this->assertSame($array_entity, $entity->toArrayFromStore());
    }
  }
