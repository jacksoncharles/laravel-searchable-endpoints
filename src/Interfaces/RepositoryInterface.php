<?php namespace WebConfection\LaravelRepositories\Interfaces;

interface RepositoryInterface 
{
    /**
     * Abstract method that will return a string matching the associated model including namespace.
     * For example: "App/MyClass"
     *
     * @return  string
     */
    public function model();

    /**
     * Returns a collection of models
     *
     * @param  array    $columns
     * @param  boolean  $withTrash 
     *
     * @return Illuminate\Database\Eloquent\Collection
     */	
    public function all( $columns = array('*'), $withTrash = false);
 
    /**
     * Return a length-aware paginated list of model instances inside a collection.
     * 
     * @param  integer $rows
     * @param  array   $columns
     * @param  boolean $withTrash
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */ 
    public function paginate($perPage = 15, $columns = array('*'), $withTrash = false );
 
    /**
     * Create a new instance in permanent storage and assign results to model property.
     * 
     * @param array $data
     * 
     * @return mixed
     */
    public function create(array $data);

    /**
     * Update an existing instance in permanent storage.
     * 
     * @param array $data
     * @param $id
     * @param string $attribute
     * @return mixed
     */
    public function update($id, array $data );

    /**
     * Destroys an instance by primary key.
     * 
     * @param  integer $id
     * @return boolean
     */
    public function delete($id);

    /**
     * Forces a hard delete by primary key
     * 
     * @param  integer $id
     * @return boolean
     */
    public function forceDelete($id);
 
    /**
     * Return instance of the current model by primary key.
     * 
     * @param  integer $id
     * @param  array   $columns
     * 
     * @return Illuminate\Database\Eloquent\Model
     */
    public function find($id, $columns = array('*'));
 
     /**
     * Return the first occurence that matches the criteria passed.
     * 
     * @param $attribute
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findBy( $field, $value, $columns = array('*') );

    /**
     * Return the first occurence that matches the criteria passed.
     * 
     * @param array $columns
     * 
     * @return mixed
     */
    public function first( $columns = array('*') );

    /**
     * Return a count of the current query
     * 
     * @return integer
     */
    public function count();

    /**
     * Returns a key/value array.
     * 
     * @param  mixed   $value
     * @param  string  $key
     * @param  boolean $distinct
     * @return array
     */
    public function lists($value, $key, $distinct = false );

    /**
     * Accepts an array of nested data names to be retrieved with the
     * query
     * 
     * @param array $nestedData
     * @return $this
     */
    public function setNestedData( array $nestedData );

    /**
     * Returns an array of nested data names associated to the query.
     * 
     * @return array
     */
    public function getNestedData();

    /**
     * Standard setter for class property $query
     *
     * @param  Illuminate\Database\Eloquent\Builder $query
     * @return $this
     */
    //public function setQuery( Builder $query );

    /**
     * Standard getter for class property $query
     * 
     * @return Illuminate\Database\Builder
     */
    public function getQuery();

    /**
     * Standard setter for class property $model
     * 
     * @param \Illuminate\Database\Eloquent\Model
     * @return  $this
     */
    //public function setModel( Model $model );

    /**
     * Standard getter for the class property $model
     * 
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getModel();

    /**
     * Standard getter for class property $criteria
     * 
     * @return array
     */
    public function getCriteria();
        
    /**
     * Accepts a criteria object and adds to the eloquent query
     * 
     * @param Criteria $criteria
     * @return $this
     */
    public function pushCriteria( $criteria );
}