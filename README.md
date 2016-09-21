# Laravel/Lumen Searchable Repositories
Simple and easy implementation of the repository pattern for Laravel/Lumen with generic
[criteria objects](https://github.com/WebConfection/laravel-repositories/tree/master/src/Criteria) and a parameter trait](https://github.com/WebConfection/package-laravel-repositories/tree/master/src/Traits) specifically designed to provide enhanced search capability of your API endpoints.

## Installation
Install with composer.

```
require laravel-searchable-repositories
```

## Usage
Extend a repository to use the abtract repository as follows and include any traits you wish.

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
Methods are not limited the listing below; and further details can be found inside the [interface](https://github.com/WebConfection/laravel-repositories/blob/master/src/Interfaces/AbstractInterface.php)

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

### Todo
1. Unit tests

### Contributors
[Charles Jackson](https://github.com/jacksoncharles)
