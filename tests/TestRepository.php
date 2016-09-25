<?php namespace WebConfection\Repositories\Tests;

use WebConfection\Repositories\Repository;

class TestRepository extends Repository {

    public function __construct( $model )
    {
        $this->setModel( $model );
        parent::__construct();        
    }

	public function model()
	{
		return 'WebConfection\Repositories\Tests\TestModel';
	}
}