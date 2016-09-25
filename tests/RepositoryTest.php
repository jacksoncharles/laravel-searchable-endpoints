<?php namespace WebConfection\Repositories\Tests;

use Illuminate\Container\Container as App;

use WebConfection\Repositories\Tests\Test;
use WebConfection\Repositories\Tests\Models\FooBar;
/**
 * @coversDefaultClass \WebConfection\Repositories\Repository
 */
class RepositoryTest extends Test {

    public function setUp() 
    {

        parent::setUp();

        $this->repository = new \Webconfection\Repositories\Tests\Repositories\FooBarRepository( new App );
    }
    
    public function testRepository()
    {
        $this->assertTrue(true);
    }

    public function testAllMethod()
    {
        $result = FooBar::all();
        var_dump( $result );
        die();
        $result = $this->repository->all();
        $this->assertTrue( $count == 3 );
    }
}