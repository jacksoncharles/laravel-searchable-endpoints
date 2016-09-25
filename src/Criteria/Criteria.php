<?php namespace WebConfection\Repositories\Criteria;

use WebConfection\Repositories\Interfaces\CriteriaInterface;

class Criteria {

    /**
	 * Assign properties injected via the construct to the class
	 *
	 * @return $this
	 */
	public function __construct( array $properties )
	{
		foreach( $properties as $key => $value )
		{
			$this->{$key} = $value;
		}
	}

}