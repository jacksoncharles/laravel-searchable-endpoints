<?php namespace WebConfection\Repositories\Tests;

use Illuminate\Container\Container as App;

use WebConfection\Repositories\Tests\Test;
use WebConfection\Repositories\Tests\Models\Foo;
use WebConfection\Repositories\Tests\Models\Bar;

class OrderByTest extends Test {

    public function setUp() 
    {
        parent::setUp();

        $this->repository = new \Webconfection\Repositories\Tests\Repositories\FooRepository( new App );

        Foo::truncate();
        Foo::insert( $this->getFoos(5) );
    }

    /**
     * @group criteria
     * @covers \WebConfection\Repositories\Criteria\OrderByParameter
     * @test
     */
    public function test_order_by_asc_parameter()
    {
        $result = $this->repository->setOrder(['id' => 'ASC'])->first();

        $this->assertTrue( $result->id == 1 );
    }

    /**
     * @group criteria
     * @covers \WebConfection\Repositories\Criteria\OrderByParameter
     * @test
     */
    public function test_order_by_desc_parameter()
    {
        $result = $this->repository->setOrder(['body' => 'DESC'])->first();

        $this->assertTrue( $result->id == 5 );
    }
}