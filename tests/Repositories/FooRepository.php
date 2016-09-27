<?php namespace WebConfection\Repositories\Tests\Repositories;

use WebConfection\Repositories\Repository;

class FooRepository extends Repository {

	public function model()
	{
		return 'WebConfection\Repositories\Tests\Models\Foo';
	}
}