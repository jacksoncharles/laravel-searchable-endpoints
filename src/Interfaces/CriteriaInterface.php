<?php namespace WebConfection\Repositories\Interfaces;

interface CriteriaInterface 
{

    /**
     * Apply thew criteria to the query passed as a parameter
     *
     * @param  array key/values pairs
     * @param  object $repository
     * 
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function __construct( array $properties  );

    /**
     * Apply thew criteria to the query passed as a parameter
     *
     * @param  object $query
     * @param  object $repository
     * 
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function apply( $query, $repository  );
}