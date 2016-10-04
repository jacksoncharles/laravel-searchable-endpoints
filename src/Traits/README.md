# ParameterTrait
The ParameterTrait is enabled by default and allows you to pass a multi-dimensional array of key/values into your repository using the "setParameters" method which will then be used to build the query. The key of each array maps to a searchable item (eg: database column) in permanent storage.

The following comparison operators are supported

##### with
Array of relationship names. Deeply nested data can be retrieved using the DOT notation.
```
	array(
		'with'	=>	array(
			'bars'
		)
	);
```
##### order_by
Key/value pair of column name and direction.
```
	array(
		'order_by'	=>	array(
			'Foo'	=>	'DESC'
	);
```

##### like
All keys must contain their associated value.

```
	array(
		'like'	=>	array(
			'Foo'	=>	array(
				'Bar'
			),
			'Bar'	=>	array(
				'Foo'
			)
	);
```
##### or_like
Any of the keys contain any their associated value.

```
	array(
		'or_like'	=>	array(
			'Foo'	=>	array(
				'Bar'
			),
			'Bar'	=>	array(
				'Foo'
			)
	);
```

##### not_like
Non of the keys contain their associated value.

```
	array(
		'not_like'	=>	array(
			'Foo'	=>	array(
				'Bar'
			),
			'Bar'	=>	array(
				'Foo'
			)
	);
```

##### equal
All keys must match their associated value. 

```
	array(
		'equal'	=>	array(
			'Foo'	=>	array(
				'Bar'
			)
	);
```	
##### gte
All keys must contain a value greater than or equal too their associated value.

```
	array(
		'gte'	=>	array(
			'Foo'	=>	array(
				1
			)
	);
```		
##### gt
All keys must contain a value greater than their associated value.

```
	array(
		'gt'	=>	array(
			'Foo'	=>	array(
				1
			)
	);
```		
##### lte
All keys must contain a value less than or equal too their associated value.

```
	array(
		'lte'	=>	array(
			'Foo'	=>	array(
				99
			)
	);
```		
##### lt
All keys must contain a value less than their associated value.

```
	array(
		'lt'	=>	array(
			'Foo'	=>	array(
				99
			)
	);
```		
##### in
The key contains any of the values listed in their associated value(s)

```
	array(
		'in'	=>	array(
			'Foo'	=>	array(
				'Bar1',
				'Bar2',
				'Bar3'
			)
	);
```	
