# Criteria Objects

Comes complete with 12 generic criteria objects that can be used when building a query and are accessible via two repository methods `setParameters()` and `setOrder()`.

## setParameters()
All parameters can be set using multi-dimensional arrays as described in the [parameter trait](https://github.com/WebConfection/package-laravel-repositories/tree/master/src/Traits).

### 1. BetweenCriteria

### 2. EqualsCriteria

### 3. GreaterThanCriteria

### 4. GreaterThanEqualsCriteria

### 5. InArrayCriteria

### 6. LessThanCriteria

### 7. LessThanEqualsCriteria

### 8. LikeCriteria

### 9. NotLikeCriteria

### 10. OrEqualsCriteris

### 11. OrLikeCriteris

## setOrder()
You can set the order of a query using a key/value pair of column/direction for example ['created_at' => 'desc'].

### 1. OrderByCriteria


