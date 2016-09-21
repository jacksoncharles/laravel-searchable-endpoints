ƒ<?php namespace WebConfection\LaravelRepositories\Traits;

use WebConfection\LaravelRepositories\Exceptions\RepositoryException;

use WebConfection\LaravelRepositories\Criteria\BetweenCriteria;
use WebConfection\LaravelRepositories\Criteria\EqualsCriteria;
use WebConfection\LaravelRepositories\Criteria\GreaterThanCriteria;
use WebConfection\LaravelRepositories\Criteria\GreaterThanEqualsCriteria;
use WebConfection\LaravelRepositories\Criteria\InArrayCriteria;
use WebConfection\LaravelRepositories\Criteria\LessThanCriteria;
use WebConfection\LaravelRepositories\Criteria\LessThanEqualsCriteria;
use WebConfection\LaravelRepositories\Criteria\LikeCriteria;
use WebConfection\LaravelRepositories\Criteria\NotLikeCriteria;
use WebConfection\LaravelRepositories\Criteria\OrEqualsCriteria;
use WebConfection\LaravelRepositories\Criteria\OrLikeCriteria;


trait ParameterTrait {

    /**
     * Loop through a multi dimensional array of parameters and craete the criteria
     * 
     * @param   array $parameters
     * @return  void
     */
    public function setParameters( array $parameters )
    {
        foreach( $parameters as $rule => $columns )
        {
            switch( strtolower( $rule ) )
            {
                case 'or_like':
                    $this->pushCriteria( new OrLikeCriteria( ['values' => $columns ] ) );
                    break;
                case 'or_equal':
                    $this->pushCriteria( new OrEqualsCriteria( ['values' => $columns ] ) );
                    break;
                case 'in':
                case 'between':
                    $this->complexComparisons( $rule, $columns );
                    break;            
                case 'like':
                case 'not_like':
                case 'equal':
                case 'gte':
                case 'gt':
                case 'lte':
                case 'lt':
                    $this->primitiveComparisons( $rule, $columns );
                    break;
                default:
                    throw new RepositoryException("malformed parameter passed into the repository : ".$rule);
                    break;
            }
        }
    }

    /**
     * Loop through the values passed as a parameter and create the criteria
     * 
     * @param  string $rule
     * @param  string $column
     * @param  array  $values
     * @return void
     */
    public function complexComparisons( $rule, $columns )
    {
        foreach( $columns as $column => $values )
        {
            switch( strtolower( $rule ) )
            {
                case 'in':
                    $this->pushCriteria( new InArrayCriteria([ 'column' => $column, 'value' => $values ]) );
                    break;            
                case 'between':
                    $this->pushCriteria( new BetweenCriteria([ 'column' => $column, 'from' => array_shift( $values ), 'to' => array_shift( $values )]) );
                    break;
                default:
                    throw new RepositoryException("malformed complex parameter passed into the repository");
                    break;
            }
        }
    }

    /**
     * Loop through the values passed as a parameter and create the criteria
     * 
     * @param  string $rule
     * @param  string $column
     * @param  array  $values
     * @return void
     */
    public function primitiveComparisons( $rule, $columns )
    {
        foreach( $columns as $column => $values )
        {
            foreach( $values as $value )
            {
                if( !empty( trim( $value ) ) )
                {
                    switch( strtolower( $rule ) )
                    {
                        case 'like':
                            $this->pushCriteria( new LikeCriteria([ 'column' => $column, 'value' => $value ]) );
                            break;
                        case 'not_like':
                            $this->pushCriteria( new NotLikeCriteria([ 'column' => $column, 'value' => $value ]) );
                            break;
                        case 'equal':
                            $this->pushCriteria( new EqualsCriteria([ 'column' => $column, 'value' => $value ]) );
                            break;            
                        case 'gte':
                            $this->pushCriteria( new GreaterThanEqualsCriteria([ 'column' => $column, 'value' => $value ]) );
                            break;            
                        case 'gt':
                            $this->pushCriteria( new GreaterThanCriteria([ 'column' => $column, 'value' => $value ]) );
                            break;            
                        case 'lte':
                            $this->pushCriteria( new LessThanEqualsCriteria([ 'column' => $column, 'value' => $value ]) );
                            break;            
                        case 'lt':
                            $this->pushCriteria( new LessThanCriteria([ 'column' => $column, 'value' => $value ]) );
                            break;
                        default:
                            throw new RepositoryException("malformed complex parameter passed into the repository");
                            break;
                    }
                }
            }
        }
    }
}