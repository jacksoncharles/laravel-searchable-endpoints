<?php namespace WebConfection\Repositories\Criteria;

use WebConfection\Repositories\Interfaces\CriteriaInterface;
use WebConfection\Repositories\Criteria\Criteria;

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