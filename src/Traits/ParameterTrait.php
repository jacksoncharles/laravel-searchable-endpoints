<?php namespace WebConfection\Repositories\Traits;

use WebConfection\Repositories\Exceptions\RepositoryException;

use WebConfection\Repositories\Criteria\BetweenCriteria;
use WebConfection\Repositories\Criteria\EqualsCriteria;
use WebConfection\Repositories\Criteria\GreaterThanCriteria;
use WebConfection\Repositories\Criteria\GreaterThanEqualsCriteria;
use WebConfection\Repositories\Criteria\InArrayCriteria;
use WebConfection\Repositories\Criteria\LessThanCriteria;
use WebConfection\Repositories\Criteria\LessThanEqualsCriteria;
use WebConfection\Repositories\Criteria\LikeCriteria;
use WebConfection\Repositories\Criteria\NotLikeCriteria;
use WebConfection\Repositories\Criteria\OrEqualsCriteria;
use WebConfection\Repositories\Criteria\OrLikeCriteria;
use WebConfection\Repositories\Criteria\OrderByCriteria;

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
                case 'with':
                    $this->with = $columns;
                    break;
                case 'order_by':
                    $this->criteria[] = new OrderByCriteria( ['column' => key( $columns ), 'direction' => array_shift( $columns ) ] );
                    break;
                case 'or_like':
                    $this->criteria[] = new OrLikeCriteria( ['values' => $columns ] );
                    break;
                case 'or_equal':
                    $this->criteria[] = new OrEqualsCriteria( ['values' => $columns ] );
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

        return $this;
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
                    $this->criteria[] = new InArrayCriteria( [ 'column' => $column, 'value' => $values ] );
                    break;            
                case 'between':
                    $this->criteria[] = new BetweenCriteria( [ 'column' => $column, 'from' => array_shift( $values ), 'to' => array_shift( $values )] );
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
                            $this->criteria[] = new LikeCriteria( [ 'column' => $column, 'value' => $value ] );
                            break;
                        case 'not_like':
                            $this->criteria[] = new NotLikeCriteria( [ 'column' => $column, 'value' => $value ] );
                            break;
                        case 'equal':
                            $this->criteria[] = new EqualsCriteria( [ 'column' => $column, 'value' => $value ] );
                            break;            
                        case 'gte':
                            $this->criteria[] = new GreaterThanEqualsCriteria( [ 'column' => $column, 'value' => $value ] );
                            break;            
                        case 'gt':
                            $this->criteria[] = new GreaterThanCriteria( [ 'column' => $column, 'value' => $value ] );
                            break;            
                        case 'lte':
                            $this->criteria[] = new LessThanEqualsCriteria([ 'column' => $column, 'value' => $value ] );
                            break;            
                        case 'lt':
                            $this->criteria[] = new LessThanCriteria([ 'column' => $column, 'value' => $value ] );
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