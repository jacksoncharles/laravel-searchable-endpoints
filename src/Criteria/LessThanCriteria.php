<?php namespace WebConfection\LaravelRepositories\Criteria;

use WebConfection\LaravelRepositories\Interfaces\CriteriaInterface;
use WebConfection\LaravelRepositories\Criteria\Criteria;

class LessThanCriteria extends Criteria implements CriteriaInterface {

    /**
	 * The filter is a date and must be formatted accordingly
	 *
	 * @return $this
	 */
    public function apply( $query, $repository )
    {
		$query->where( $this->column, '<', $this->value );  // Non-empty string for example; posted a story id        

        return $query;
    }

}