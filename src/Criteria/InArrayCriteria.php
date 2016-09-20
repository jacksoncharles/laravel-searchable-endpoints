<?php namespace WebConfection\LaravelRepositories\Criteria;

use WebConfection\LaravelRepositories\Interfaces\CriteriaInterface;
use WebConfection\LaravelRepositories\Criteria\Criteria;

class InArrayCriteria extends Criteria implements CriteriaInterface {

    /**
	 * The filter is a date and must be formatted accordingly
	 *
	 * @return $this
	 */
    public function apply( $query, $repository )
    {
    	$query->whereIn( $this->column, $this->value );

        if( in_array('NULL', $this->value ) ) $query->orWhereNull( $this->column );

        return $query;
    }
}