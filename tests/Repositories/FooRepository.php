<?php namespace WebConfection\Repositories\Tests\Repositories;

use WebConfection\Repositories\Repository;
use WebConfection\Repositories\Interfaces\RepositoryInterface;

class FooRepository extends Repository implements RepositoryInterface {

	public function model()
	{
		return 'WebConfection\Repositories\Tests\Models\Foo';
	}
}