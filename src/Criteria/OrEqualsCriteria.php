<?php namespace WebConfection\LaravelRepositories\Criteria;

use WebConfection\LaravelRepositories\Interfaces\CriteriaInterface;
use WebConfection\LaravelRepositories\Criteria\Criteria;

class OrEqualsCriteria extends Criteria implements CriteriaInterface {

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

              $q->orWhere( $column, '=', $value );
            }
		});

		return $query;
    }

}