# Illuminate Searchable Repositories
Easy implementation of the [Repository Pattern](https://bosnadev.com/2015/03/07/using-repository-pattern-in-laravel-5/) for 
the [Illuminate Database Package](https://github.com/illuminate). In addition to eleven conventional methods there is a further setParameters() solution that can be used to build a select query using multidimensional arrays. 

The package is specifically designed to enable fast and easy creation of searchable API endpoints.

## Installation
Install with composer.

```
require illuminate-searchable-repositories
```

## Usage
Extend your repository to use WebConfection\Repositories\Repository and implement the WebConfection\Repositories\Interfaces\RepositoryInterface. Then include the model() method returning
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

## Methods
Methods are not limited to the listing below; Further details can be found inside the [interface](https://github.com/WebConfection/laravel-repositories/blob/master/src/Interfaces/AbstractInterface.php).

```
    public function all( $columns = ['*'], $withTrash = false )
 
    public function paginate( $rows = 10, $columns = ['*'], $withTrash = false )
 
    public function find( $id, $columns = ['*'], $withTrash = false )
 
    public function findBy( array $attributes, $columns = ['*'], $withTrash = false ) 

    public function first( $columns = ['*'], $withTrash = flase ) 

    public function count( $withTrash = false )

    public function lists( $key, $value );

    public function create(array $data);
 
    public function update(array $data, $id);
 
    public function delete($id);

    public function forceDelete($id);

    public function setParameters( array $parameters );
 
```

## Parameter Trait
The [parameter trait](https://github.com/WebConfection/illuminate-searchable-repositories) enables you to pass a multi-dimensional array into your repository using the setParameters() method. The parameter will then be used to build your query and the results
can be retrieved used of any the repository methods. 

The following comparison operators are supported. Where the key of each array maps to a searchable item (eg: database column) in permanent storage.

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



### Contributors
[Charles Jackson](https://github.com/jacksoncharles)
