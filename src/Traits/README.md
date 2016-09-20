# Base64UploadTrait
Enables you to upload an asset to AWS storage. Columns containing base64 encoded data must be suffixed _base64. To use this
trait include in the repository that extends the abstract class.

You wish to save details of an uploaded asset in columns named "avatar" and "avatar_mimetype" that belong to the "User" model? Post the 
base64 encoded data array inside a column called "avatar_base64" and the Base64UploadTrait trait will store the file inside a folder 
called "User/< primaryKey >/< filename >" within your chosen AWS bucket and auto-populate "avatar" and "avatar_mimetype" properties accordingly. 

For example; Consider the following array

```
'avatar_base64' = [
	'filename'		=>		'Name of the asset being uploaded'
	'base64'		=>		'String containing the bases64 encoded value'
]
```
... will auto populate the following model properties

```
'avatar'			=	Will contain the path/fiilename of the uploaded asset relative to it's S3 bucket (Mandatory)
'avatar_mimetype'	=	Will contain the mimetype of the uploaded asset (Optional)
```
... and store the image inside the following folder structure.
```
User/<primaryKey>/<filename>
```
#### OPTIONS
The following options are available

##### S3 Bucket 
Specify the S3 bucket name within config/filesystems.php

##### Resizing
Create a repository property called $resizeImages and using an array of key/value pairs specify the name of the subfolder and height in pixels of the resixed image for example;
```
public $imageResize = [
	'thumbnail' 	=>		50,
	'medium'		=>		150
	'large'			=>		300
];
```

# ParameterTrait
The ParameterTrait is enabled by default and allows you to pass a multi-dimensional array of key/values into your repository using the "setParameters" method which will then be used to build the query. The key of each array maps to a searchable item (eg: database column) in permanent storage.

The following comparison operators are supported

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
		'not_contain'	=>	array(
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
