# Illuminate Searchable Repositories
Implementation of the [Repository Pattern](https://bosnadev.com/2015/03/07/using-repository-pattern-in-laravel-5/) for 
the [Illuminate Database Package](https://github.com/illuminate) specifically designed to facilitate the easy creation of searchable API endpoints. In addition to ten conventional methods there are a further 13 search criteria which can be passed to your repository as multidimensional arrays using the setParameters() solution. 

1. Installation
2. [Implementation](#Implementation)
 1. [Example Controller](#Example-Controller::index)
3. [Methods](#Methods)
4. [Parameter Trait](#Parameter-Trait)
5. Tests
6. Contributors

## Installation
Install with composer.

```
composer require illuminate-searchable-repositories
```

## Implementation
Extend your repository to use WebConfection\Repositories\Repository and implement the WebConfection\Repositories\Interfaces\RepositoryInterface. Then create a model() method returning
a namespaced string to your associated model.

```
    use WebConfection\Repositories\Repository;
    use WebConfection\Repositories\Interfaces\RepositoryInterface;

    class MyRepository extends Repository implements RepositoryInterface
    {
        /**
         * Specify Model class name
         *
         * @return mixed
         */
        function model()
        {
            return 'App\MyRepository';
        }
    
    }

```
### Example Controller::index
In the following controller::index implementation I have bound an interface to a repository and injected
the repository into the __construct of my controller.

```
...

class FooBarsController extends Controller
{
    public function __construct( FooBarInterface $fooBarRepository )
    {
       $this->repository = $fooBarRepository;
    }

    /**
     * Return a JSON encoded listing including filters
     *
     * @return array
     */
    public function index()
    {

        if( Input::has('parameters') ) $this->repository->setParameters( Input::get('parameters') );
        
        if( Input::has('rows') )
        {
            $data = $this->repository->paginate( Input::get('rows'), Input::has('trash') )->toArray();
        } 
        else
        {
            $data = $this->repository->all( Input::has('trash') )->toArray();
        }

        return response()->json( $data, 200 );
    }
```

## Methods
Further details can be found inside the [interface](https://github.com/webconfection/illuminate-searchable-repositories/blob/master/src/Interfaces/RepositoryInterface.php).

```
    public function all( $columns = ['*'], $withTrash = false )
 
    public function paginate( $rows = 10, $columns = ['*'], $withTrash = false )
 
    public function find( $id, $columns = ['*'], $withTrash = false )
 
    public function findBy( array $attributes, $columns = ['*'], $withTrash = false ) 

    public function first( $columns = ['*'], $withTrash = flase ) 

    public function count( $withTrash = false )

    public function create( array $data ) 
 
    public function update( $id, array $data )
 
    public function delete( $id )

    public function forceDelete( $id )
 
```

## Parameter Trait
The [parameter trait](https://github.com/webconfection/illuminate-searchable-repositories/blob/master/src/Traits/ParameterTrait.php) enables you to pass a multi-dimensional array into your repository using the setParameters() method. The parameter will then be used to build your query and the results can be retrieved using of any the convential repository methods: all, paginate, find, findBy, first and count.

Thirteen comparison operators are currently supported. Where the key of each array maps to a searchable item (eg: database column) in permanent storage. Further examples can be found inside the [test suite](https://github.com/webconfection/illuminate-searchable-repositories/blob/master/tests/CriteriaTest.php)

##### with
Array of relationship names. Deeply nested data can be retrieved using the DOT notation.
```
    array(
        'with'  =>  array(
            'bars'
        )
    );
```
##### order_by
Key/value pair of column name and direction.
```
    array(
        'order_by'  =>  array(
            'Foo'   =>  'DESC'
    );
```
#### like
All keys must contain their associated value.

```
    array(
        'like'  =>  array(
            'Foo'   =>  array(
                'Bar'
            ),
            'Bar'   =>  array(
                'Foo'
            )
    );
```
#### or_like
Any of the keys contain any their associated value.

```
    array(
        'or_like'   =>  array(
            'Foo'   =>  array(
                'Bar'
            ),
            'Bar'   =>  array(
                'Foo'
            )
    );
```

#### not_like
Non of the keys contain their associated value.

```
    array(
        'not_like'   =>  array(
            'Foo'   =>  array(
                'Bar'
            ),
            'Bar'   =>  array(
                'Foo'
            )
    );
```

#### equal
All keys must match their associated value. 

```
    array(
        'equal' =>  array(
            'Foo'   =>  array(
                'Bar'
            )
    );
``` 
#### or_equal
Any of the keys match the value

```
    array(
        'or_equal' =>  array(
            'Foo'   =>  array(
                'Foo1'
            ),
            'Bar'   =>  array(
                'Bar1'
            )

    );
``` 

#### gte
All keys must contain a value greater than or equal too their associated value.

```
    array(
        'gte'   =>  array(
            'Foo'   =>  array(
                1
            )
    );
```     
#### gt
All keys must contain a value greater than their associated value.

```
    array(
        'gt'    =>  array(
            'Foo'   =>  array(
                1
            )
    );
```     
#### lte
All keys must contain a value less than or equal too their associated value.

```
    array(
        'lte'   =>  array(
            'Foo'   =>  array(
                99
            )
    );
```     
#### lt
All keys must contain a value less than their associated value.

```
    array(
        'lt'    =>  array(
            'Foo'   =>  array(
                99
            )
    );
```     
#### in_array
The key contains any of the values listed in their associated value(s)

```
    array(
        'in_array'    =>  array(
            'Foo'   =>  array(
                'Bar1',
                'Bar2',
                'Bar3'
            )
    );
``` 
#### in
The key contains any of the values listed in their associated value(s)

```
    array(
        'between'    =>  array(
            'Foo'   =>  array(
                1,
                5
            )
    );
``` 


## Tests
All unit tests are run against an SqlLite database in memory.

## Contributors
[Charles Jackson](https://github.com/jacksoncharles)
