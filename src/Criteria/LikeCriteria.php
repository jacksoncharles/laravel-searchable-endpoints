<?php namespace WebConfection\Repositories\Criteria;

use WebConfection\Repositories\Interfaces\CriteriaInterface;
use WebConfection\Repositories\Criteria\Criteria;

class LikeCriteria extends Criteria implements CriteriaInterface {

    /**
	 * The filter is a date and must be formatted accordingly
	 *
	 * @return $this
	 */
    public function apply( $query, $repository )
    {
        $query->where( function($q) {


            $q->orWhere( $this->column, 'LIKE', '%'.$this->value.'%' );
            $q->orWhere( $this->column, 'LIKE', $this->value.'%' );
            $q->orWhere( $this->column, 'LIKE', '%'.$this->value );

		});

        return $query;
    }

}