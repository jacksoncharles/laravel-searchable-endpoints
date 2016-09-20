# Laravel/Lumen Repositories
Simple and easy implementation of the repository pattern for Laravel/Lumen.

An abstract class including predefined [criteria objects](https://github.com/HomeBargains/package-laravel-repositories/tree/master/src/Criteria) that can be expanded
upon for any implementation specific requirements plus two useful traits; The [parameter trait](https://github.com/HomeBargains/package-laravel-repositories/tree/master/src/Traits) and the [base64 trait](https://github.com/HomeBargains/package-laravel-repositories/tree/master/src/Traits), designed to facilitate API development.

## Installation
Install with composer. Until such time as we have a packages solution in place add the repository to your composer.json file.

```
    "repositories": [
        {
            "url": "https://github.com/HomeBargains/package-laravel-repositories.git",
            "type": "git"
        }
    ],
    "require": {
        "homebargain/laravel-repositories": "~0.5"
    }

```
## Usage
Extend a repository to use the abtract repository as follows and include any traits you wish.

```
    use HomeBargain\LaravelRepositories\Repositories\AbstractRepository;
    use HomeBargain\LaravelRepositories\Interfaces\RepositoryInterface;

    class MyRepository extends AbstractRepository implements RepositoryInterface
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
Methods are not limited the listing below; and further details can be found inside the [interface](https://github.com/HomeBargains/package-laravel-repositories/blob/master/src/Interfaces/AbstractInterface.php)

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
