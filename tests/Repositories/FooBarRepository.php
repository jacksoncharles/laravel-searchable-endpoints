<?php namespace WebConfection\Repositories\Tests\Repositories;

use WebConfection\Repositories\Repository;

class FooBarRepository extends Repository {

	public function model()
	{
		return 'WebConfection\Repositories\Tests\FooBarModel';
	}
}