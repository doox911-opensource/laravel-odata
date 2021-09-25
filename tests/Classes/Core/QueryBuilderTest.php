<?php

  namespace Doox911Opensource\LaravelOData\Tests\Classes\Core;

  use Orchestra\Testbench\TestCase;
  use Illuminate\Foundation\Application;
  use Doox911Opensource\LaravelOData\Classes\Core\Filter;
  use Doox911Opensource\LaravelOData\Classes\Core\Select;
  use Doox911Opensource\LaravelOData\Classes\Core\Expand;
  use Doox911Opensource\ValueObjects\Exceptions\ValueObjectsException;
  use Doox911Opensource\LaravelOData\Exceptions\LaravelODataException;
  use Doox911Opensource\LaravelOData\Providers\LaravelODataServiceProvider;
  use Doox911Opensource\LaravelOData\Tests\Classes\Core\Instances\QueryBuilderInstance;
  use Doox911Opensource\LaravelOData\Classes\Enums\HTTPMethod;

  class QueryBuilderTest extends TestCase
  {

    /**
     * Добавление сущности
     *
     * С этого метода начинается работа с QueryBuilder
     */
    public function testFrom()
    {
      $entity = 'Products';

      $builder = QueryBuilderInstance::from($entity);

      $this->assertSame($entity, $builder->getEntity()->value);
    }

    /**
     * Добавление фильтра
     *
     * @throws LaravelODataException|ValueObjectsException
     */
    public function testAddFilter()
    {
      $builder = QueryBuilderInstance::new();

      $builder
        ->filters(fn(Filter $filter) => $filter
          ->add('Номенклатура_Key', 'eq', 'cbc3f66c-f3c9-11e9-80ce-00155d0a3509')
          ->guid()
        );

      $collection = $builder->getFilters();

      $this->assertSame(1, $collection->length());

      $filter = $collection->last();

      $this->assertSame('Номенклатура_Key', $filter->field);
      $this->assertSame('eq', $filter->operator);
      $this->assertSame('guid\'cbc3f66c-f3c9-11e9-80ce-00155d0a3509\'', $filter->value);
    }

    /**
     * Добавление выборки
     *
     * @throws LaravelODataException|ValueObjectsException
     */
    public function testAddSelect()
    {
      $builder = QueryBuilderInstance::addSelect('Номенклатура_Key');

      $collection = $builder->getSelects();

      $this->assertSame(1, $collection->length());

      $filter = $collection->last();

      $this->assertSame('Номенклатура_Key', $filter->value);
    }

    /**
     * Get-запрос
     *
     * @throws LaravelODataException|ValueObjectsException
     */
    public function testGetWithFiltersWithSelects()
    {
      $entity = 'Products';

      $builder = QueryBuilderInstance::from($entity);

      $response = $builder
        ->expand(fn(Expand $expand) => $expand->add('ID'))
        ->filter('ID', 'gt', 2)
        ->filters(fn(Filter $filter) => $filter->scope(fn(Filter $filter) => $filter
          ->orAdd('Price', 'ge', 15)
          ->orAdd('Price', 'le', 30)
        ))
        ->select(fn(Select $select) => $select->add('ID'))
        ->select('Name')
        ->select('Price', 'Description')
        ->select(['ReleaseDate', 'DiscontinuedDate'])
        ->request(HttpMethod::GET());

      $this->assertSame(200, $response->getStatusCode());
    }

    /**
     * Get-запрос метод find
     *
     * @throws LaravelODataException|ValueObjectsException
     */
    public function testFind()
    {
      $entity = 'Products';

      $builder = QueryBuilderInstance::from($entity);

      $response = json_decode($builder->find(0));

      $this->assertSame(
        'https://services.odata.org/V3/(S(atwmlvm4mo23p20k53tu0fjr))/OData/OData.svc/$metadata#Products',
        $response->{'odata.metadata'}
      );
    }

    /**
     * Добавить порядок выборки
     *
     * @throws ValueObjectsException
     * @throws LaravelODataException
     */
    public function testOrderBy()
    {
      $entity = 'Products';

      $builder = QueryBuilderInstance::from($entity);

      $response = $builder
        ->order('ID')
        ->take(10)
        ->request(HttpMethod::GET());

      $this->assertSame(200, $response->getStatusCode());
    }

    /**
     * @param Application $app
     * @return string[]
     */
    protected function getPackageProviders($app): array
    {
      return [
        LaravelODataServiceProvider::class,
      ];
    }
  }
