<?php namespace HomeBargain\LaravelRepo\Criteria;

use HomeBargain\LaravelRepo\Interfaces\CriteriaInterface;
use HomeBargain\LaravelRepo\Criteria\Criteria;

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