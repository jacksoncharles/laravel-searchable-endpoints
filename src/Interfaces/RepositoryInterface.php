<?php namespace WebConfection\Repositories\Interfaces;

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
    public function all( $columns = ['*'], $withTrash = false );
 
    /**
     * Return a length-aware paginated list of model instances inside a collection.
     * 
     * @param  integer $rows
     * @param  array   $columns
     * @param  mixed   $page
     * @param  boolean $withTrash
     * @return Illuminate\Pagination\LengthAwarePaginator
     */ 
    public function paginate( $rows = 10, $columns = ['*'], $page = false, $withTrash = false );

    /**
     * Return instance of the current model by primary key.
     * 
     * @param  integer $id
     * @param  array   $columns
     * 
     * @return Illuminate\Database\Eloquent\Model
     */
    public function find( $id, $columns = ['*'], $withTrash = false );
 
     /**
     * Return the first occurence that matches the criteria passed.
     * 
     * @param $attribute
     * @param $value
     * @param array $columns
     * @return Illuminate\Database\Eloquent\Model
     */
    public function findBy( array $attributes, $columns = ['*'], $withTrash = false );

    /**
     * Return the first occurence that matches the criteria passed.
     * 
     * @param array $columns
     * 
     * @return Illuminate\Database\Eloquent\Model
     */
    public function first( $columns = ['*'], $withTrash = flase );

    /**
     * Return a count of the current query
     * 
     * @return integer
     */
    public function count( $withTrash = false );
 
    /**
     * Create a new instance in permanent storage and assign results to model property.
     * 
     * @param array $data
     * 
     * @return mixed
     */
    public function create( array $data );

    /**
     * Update an existing instance in permanent storage.
     * 
     * @param array $data
     * @param $id
     * @param string $attribute
     * @return mixed
     */
    public function update( $id, array $data );

    /**
     * Destroys an instance by primary key.
     * 
     * @param  integer $id
     * @return boolean
     */
    public function delete( $id );

    /**
     * Forces a hard delete by primary key
     * 
     * @param  integer $id
     * @return boolean
     */
    public function forceDelete( $id );
}