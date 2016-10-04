# Illuminate Searchable Repositories
Implementation of the [Repository Pattern](https://bosnadev.com/2015/03/07/using-repository-pattern-in-laravel-5/) for 
the [Illuminate Database Package](https://github.com/illuminate) specifically designed to facilitate the easy creation of searchable API endpoints. In addition to ten conventional methods there are a further 13 search criteria which can be passed to your repository as multidimensional arrays using the setParameters() solution. 

This package has been tested against illuminate ^5.2 as used by [Laravel/Lumen 5.3](https://laravel.com/).

1. <a href="#installation">Installation</a>
2. <a href="#implementation">Implementation</a>
 1. <a href="#model">Model</a>
 2. <a href="#repository">Repository</a>
 3. <a href="#example-controller">Example Controller</a>
3. <a href="#methods">Methods</a>
4. <a href="#parameter-trait">Parameter Trait</a>
 1. <a href="#with">With</a>
 2. <a href="#order_by">Order By</a>
 3. <a href="#like">Like</a>
 4. <a href="#or_like">Or Like</a>
 5. <a href="#not_like">Not Like</a>
 6. <a href="#equal">Equal</a>
 7. <a href="#or_equal">Or Equal</a>
 8. <a href="#gte">Greater Than or Equal</a>
 9. <a href="#gt">Greater Than</a>
 10. <a href="#lte">Less Than or Equal</a>
 11. <a href="#lt">Less Than</a>
 12. <a href="#in_array">In Array</a>
 12. <a href="#between">Between</a>
5. <a href="#tests">Tests</a>
6. <a href="#contributors">Contributors</a>

## Installation
Install with composer.

```
composer require illuminate-searchable-repositories
```

## Implementation

### Model
Start by creating an Eloquent model
```php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FooBar extends Model {

    use SoftDeletes;

    /**
     * @var string
     *
     * The table for the model.
     */
    protected $table = 'foo_bars';

    /**
     * @var array
     *
     * Columns that can be filled by mass assigment
     */
    protected $fillable = ['id','body'];
}
```
### Repository
Create a repository and extend to use *WebConfection\Repositories\Repository* and implement the *WebConfection\Repositories\Interfaces\RepositoryInterface*. Then create a model() method returning
a namespaced string to the model you just created.

```php
    namespace App\Repositories;

    use WebConfection\Repositories\Repository;
    use WebConfection\Repositories\Interfaces\RepositoryInterface;

    class FooBarRepository extends Repository implements RepositoryInterface
    {
        /**
         * Specify Model class name
         *
         * @return mixed
         */
        function model()
        {
            return 'App\FooBar';
        }
    }

```
### Example Controller ::index
In the following controller::index implementation I have bound an interface to a repository and injected
the repository into the __construct of my controller.

```php
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

```php
    public function all( $columns = ['*'], $withTrash = false )
 
    public function paginate( $rows = 10, $columns = ['*'], $page = false, $withTrash = false )
 
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
The [parameter trait](https://github.com/webconfection/illuminate-searchable-repositories/blob/master/src/Traits/ParameterTrait.php) enables you to pass a multi-dimensional array into your repository using the setParameters() method. The parameter will then be used to build your query and the results can be retrieved using of any the conventional repository methods: *all*, *paginate*, *find*, *findBy*, *first* and *count*.

Thirteen comparison operators are currently supported. Where the key of each array maps to a searchable item (eg: database column) in permanent storage. Further examples can be found inside the [test suite](https://github.com/webconfection/illuminate-searchable-repositories/blob/master/tests/CriteriaTest.php)

#### with
Array of relationship names. Deeply nested data can be retrieved using the DOT notation.
```php
    array(
        'with'  =>  array(
            'bars'
        )
    );
```
#### order_by
Key/value pair of column name and direction.
```php
    array(
        'order_by'  =>  array(
            'Foo'   =>  'DESC'
    );
```
#### like
All keys must contain their associated value.

```php
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

```php
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

```php
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

```php
    array(
        'equal' =>  array(
            'Foo'   =>  array(
                'Bar'
            )
    );
``` 
#### or_equal
Any of the keys match the value

```php
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

```php
    array(
        'gte'   =>  array(
            'Foo'   =>  array(
                1
            )
    );
```     
#### gt
All keys must contain a value greater than their associated value.

```php
    array(
        'gt'    =>  array(
            'Foo'   =>  array(
                1
            )
    );
```     
#### lte
All keys must contain a value less than or equal too their associated value.

```php
    array(
        'lte'   =>  array(
            'Foo'   =>  array(
                99
            )
    );
```     
#### lt
All keys must contain a value less than their associated value.

```php
    array(
        'lt'    =>  array(
            'Foo'   =>  array(
                99
            )
    );
```     
#### in_array
The key contains any of the values listed in their associated value(s)

```php
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

```php
    array(
        'between'    =>  array(
            'Foo'   =>  array(
                1,
                5
            )
    );
``` 
#### between
The key contains a value greater than the first value and less than the second value.

```php
    array(
        'between'    =>  array(
            'Foo'   =>  array(
                1,
                5
            )
    );
``` 


## Tests
All unit tests are run against an SQLLite database in memory.

## Contributors
[Charles Jackson](https://github.com/jacksoncharles)
