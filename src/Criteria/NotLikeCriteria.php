<?php namespace HomeBargain\LaravelRepo\Criteria;

use HomeBargain\LaravelRepo\Interfaces\CriteriaInterface;
use HomeBargain\LaravelRepo\Criteria\Criteria;

class NotLikeCriteria extends Criteria implements CriteriaInterface {

    /**
	 * The filter is a date and must be formatted accordingly
	 *
	 * @return $this
	 */
    public function apply( $query, $repository )
    {
		$query->Where( $this->column, 'NOT LIKE', '%'.$this->value.'%' );
		$query->Where( $this->column, 'NOT LIKE', $this->value.'%' );
		$query->Where( $this->column, 'NOT LIKE', '%'.$this->value );

        return $query;
    }

}