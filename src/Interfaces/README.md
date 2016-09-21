## Repository Interface
Implement this interface on any repository that extends the base abstract repository and
create the one mandatory method "model()". For example;

```
...
use WebConfection\Interfaces\RepositoryInterface;
use WebConfection\Repository;
 
class FooBarRepository extends Repository implements RepositoryInterface {

   /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return 'App\FooBarRepository';
    }
```

## Criteria Interface
Implement this interface on any new criteria objects you wish to create. 