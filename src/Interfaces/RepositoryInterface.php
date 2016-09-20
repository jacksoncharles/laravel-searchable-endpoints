<?php namespace WebConfection\LaravelRepositories\Interfaces;

interface RepositoryInterface 
{
    /**
     * Abstract method that will return a string matching the associated model including namespace.
     * For example: "App/MyClass"
     *
     * @return  string
     */
    abstract function model();

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
     * Standard setter for private property $nestedData
     * 
     * @param array $nestedData
     * @return $this
     */
    public function setNestedData( array $nestedData );

    /**
     * Standard getter for privater property $nestedData
     * 
     * @return array
     */
    public function getNestedData();

    /**
     * Loop through the class property $nestedData and apply to the
     * class property $query which is an instance of the Eloquent query object.
     * 
     * @return $this
     */
    private function applyNestedData();

    /**
     * Standard setter for class property $query
     *
     * @param  Illuminate\Database\Eloquent\Builder $query
     * @return $this
     */
    public function setQuery( Builder $query );

    /**
     * Standard getter for class property $query
     * 
     * @return Illuminate\Database\Builder
     */
    public function getQuery();

    /**
     * Create an instance of the associated model retrieved from the abstract method "model" and assign to class
     * property $model
     * 
     * @return $this
     * @throws RepositoryException
     */
    private function makeModel();

    /**
     * Standard setter for class property $model
     * 
     * @param \Illuminate\Database\Eloquent\Model
     * @return  $this
     */
    private function setModel( Model $model );

    /**
     * Standard getter
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
     * Push criteria onto the class property $criteria
     * 
     * @param Criteria $criteria
     * @return $this
     */
    public function pushCriteria( $criteria );

    /**
     * Apply class property $criteria to the current query held inside class property $query
     * 
     * @return $this
     */
    private function applyCriteria();
    }    
}