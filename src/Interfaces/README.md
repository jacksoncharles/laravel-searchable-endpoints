## Repository Interface
Implement this interface on any repository that extends the base abstract repository and
create the one mandatory method "model()". For example;

```
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