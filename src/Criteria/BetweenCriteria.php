<?php namespace WebConfection\Repositories\Criteria;

use WebConfection\Repositories\Interfaces\CriteriaInterface;
use WebConfection\Repositories\Criteria\Criteria;

class BetweenCriteria extends Criteria implements CriteriaInterface {

    /**
	 * The filter is a date and must be formatted accordingly
	 *
	 * @return $this
	 */
    public function apply( $query, $repository )
    {
        $query->where( $this->column, '>=', $this->from );
        $query->where( $this->column, '<=', $this->to );

        return $query;
    }

}