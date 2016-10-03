<?php namespace WebConfection\Repositories\Tests;

use Illuminate\Container\Container as App;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use WebConfection\Repositories\Tests\Test;
use WebConfection\Repositories\Tests\Models\Foo;
use WebConfection\Repositories\Tests\Models\Bar;

/**
 * @coversDefaultClass \WebConfection\Repositories\Repository
 */
class RepositoryTest extends Test {

    public function setUp() 
    {
        parent::setUp();

        $this->repository = new \Webconfection\Repositories\Tests\Repositories\FooRepository( new App );

        Foo::truncate();
    }

    /**
     * @group repository
     * @covers ::model
     * @test
     */
    public function is_model_method_working()
    {
        $this->assertTrue( $this->repository->model() === 'WebConfection\Repositories\Tests\Models\Foo' );
    }

    /**
     * @group repository
     * @covers ::all
     * @test
     */
    public function is_all_method_working()
    {
        Foo::insert( $this->getFoos(4) );

        $result = $this->repository->all();
        
        $this->assertTrue( count( $result ) == 4 );
    }

    /**
     * @group repository
     * @covers ::paginate
     * @test
     */
    public function is_paginate_method_working()
    {
        $this->assertTrue(false);
    }

    /**
     * @group repository
     * @covers ::find
     * @test
     */
    public function is_find_method_working()
    {
        Foo::insert( $this->getFoos(4) );

        $result = $this->repository->find(2);
        
        $this->assertTrue( $result->id === 2 );
    }

    /**
     * @group repository
     * @covers ::findBy
     * @test
     */
    public function is_findBy_method_working()
    {
        Foo::insert( $this->getFoos(4) );

        $result = $this->repository->findBy(['body' => 'Foo3']);
        
        $this->assertTrue( $result->id === 3 );
    }

    /**
     * @group repository
     * @covers ::first
     * @test
     */
    public function is_first_method_working()
    {
        Foo::insert( $this->getFoos(5) );

        $result = $this->repository->first();
        
        $this->assertTrue( $result->id === 1 );
    }

    /**
     * @group repository
     * @covers ::count
     * @test
     */
    public function is_count_method_working()
    {
        Foo::insert( $this->getFoos(5) );

        $result = $this->repository->count();

        $this->assertTrue( $result === 5 );
    }

    /**
     * @group repository
     * @covers ::lists
     * @test
     */
    public function is_lists_method_working()
    {
        Foo::insert( $this->getFoos(5) );

        $results = $this->repository->lists('id','body');

        $this->assertTrue( count( $results ) === 5 );

        $counter = 1;
        foreach ( $results as $key => $value )
        {
            $this->assertTrue( $key == $counter );
            $this->assertTrue( $value == 'Foo'.$counter );

            $counter++;
        }
    }

    /**
     * @group repository
     * @covers ::create
     * @test
     */
    public function is_create_method_working()
    {
        $beforeCount = Foo::count();
        $result = $this->repository->create( $this->getFoos(1) );
        $afterCount = Foo::count();

        $this->assertTrue( $beforeCount == ( $afterCount - 1 ) );
    }

    /**
     * @group repository
     * @covers ::update
     * @test
     */
    public function is_update_method_working()
    {
        Foo::insert( $this->getFoos(5) );

        $foo = $this->repository->find( 1 )->toArray();
        $foo['body'] = 'Updated';

        $foo_updated = $this->repository->update( $foo['id'], $foo );
        $foo = $this->repository->find( $foo['id'] );

        $this->assertTrue( $foo_updated );
        $this->assertTrue( $foo->body == 'Updated' );
    }

    /**
     * @group repository
     * @covers ::delete
     * @test
     */
    public function is_delete_method_working()
    {
        // Check for soft deletion
        Foo::insert( $this->getFoos(5) );

        $beforeCount = Foo::count();

        $this->repository->delete(3);

        $afterCount = Foo::count();
        $this->assertTrue( $beforeCount === ( $afterCount + 1 ) );

        $afterCount = Foo::withTrashed()->count();
        $this->assertTrue( $beforeCount === $afterCount );
    }

    /**
     * @group repository
     * @covers ::forceDelete
     * @test
     */
    public function is_forceDelete_method_working()
    {
        Foo::insert( $this->getFoos(5) );
        $beforeCount = Foo::count();

        $this->repository->forceDelete(3);

        $afterCount = Foo::count();
        $this->assertTrue( $beforeCount === ( $afterCount + 1 ) );
    }
}