<?php namespace HomeBargain\LaravelRepo\Criteria;

use HomeBargain\LaravelRepo\Interfaces\CriteriaInterface;
use HomeBargain\LaravelRepo\Criteria\Criteria;

class OrLikeCriteria extends Criteria implements CriteriaInterface {

    /**
	 * The filter is a date and must be formatted accordingly
	 *
	 * @return $this
	 */
    public function apply( $query, $repository )
    {
        $query->where( function($q) {

            foreach( $this->values as $column => $value )
            {
            	foreach( $value as $v )
            	{
					$q->orWhere( $column, 'LIKE', '%'.$v.'%' );
				}
            }
		});

		return $query;
    }

}