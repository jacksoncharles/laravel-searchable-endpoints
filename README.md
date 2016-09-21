# Laravel/Lumen Searchable Repositories
Simple and easy implementation of the [repository pattern](https://bosnadev.com/2015/03/07/using-repository-pattern-in-laravel-5/) for Laravel/Lumen with generic
[criteria objects](https://github.com/WebConfection/laravel-repositories/tree/master/src/Criteria) and a [parameter trait](https://github.com/WebConfection/package-laravel-repositories/tree/master/src/Traits) specifically designed to provide advanced search capability of your API endpoints. YOU CAN SPECIFY


1. Search parameters
2. Nested data requirements
3. Order by clause
4. Pagination

## Installation
Install with composer.

```
require searchable-laravel-repositories
```

## Usage
Extend your repository to use the abtract repository and include the "model()" method returning
a namespaced string to your associated model.

```
    use WebConfection\LaravelRepositories\Repository;
    use WebConfection\LaravelRepositories\Interfaces\RepositoryInterface;

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

## Methods
Methods are not limited to the listing below; Further details can be found inside the [interface](https://github.com/WebConfection/laravel-repositories/blob/master/src/Interfaces/AbstractInterface.php).

```
    public function all( $columns = array('*'), $withTrash = false);
 
    public function paginate($perPage = 15, $columns = array('*'), $withTrash = false );
 
    public function create(array $data);
 
    public function update(array $data, $id);
 
    public function delete($id);

    public function forceDelete($id);
 
    public function find($id, $columns = array('*'));
 
    public function findBy($field, $value, $columns = array('*'));

	public function first( $columns = array('*') )

    public function count();

    public function lists($value, $key, $distinct = false );
```

## Search Criteria
The [parameter trait](https://github.com/WebConfection/package-laravel-repositories/tree/master/src/Traits) is enabled by default and allows you to pass a multi-dimensional array of key/values into your repository using the "setParameters" method which will then be used to build the query. The key of each array maps to a searchable item (eg: database column) in permanent storage.

The following comparison operators are supported

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
        'not_contain'   =>  array(
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
#### in
The key contains any of the values listed in their associated value(s)

```
    array(
        'in'    =>  array(
            'Foo'   =>  array(
                'Bar1',
                'Bar2',
                'Bar3'
            )
    );
``` 

## Example Implementation
In the following controller implementation I have bound an interface to a repository and injected
the repository into the construct of my controller.

```
...
use WebConfection\LaravelRepositories\Criteria\OrderByCriteria;

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
        
        if( Input::has('nested') ) $this->repository->setNestedData( Input::get('nested') );

        $order = Input::has('order') ? Input::get('order') : ['id' => 'asc'];
        $this->repository->pushCriteria( new OrderByCriteria( ['column' => key( $order ), 'direction' => array_shift( $order ) ]) );
  
        $columns = Input::has('columns') ? Input::get('columns') : ['*'];
        if( Input::has('rows') && (int)Input::get('rows') > 0 )
        {
            $data = $this->repository->paginate( Input::get('rows'), $columns, Input::has('trash') )->toArray();
        } 
        else
        {
            $data['data'] = $this->repository->all( $columns, Input::has('trash') )->toArray();
        }

        return response()->json( $data, 200 );
    }
```



### Todo
1. Unit tests

### Contributors
[Charles Jackson](https://github.com/jacksoncharles)
