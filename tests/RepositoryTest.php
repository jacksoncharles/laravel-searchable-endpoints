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
    public function test_model_method()
    {
        $this->assertTrue(false);
    }

    /**
     * @group repository
     * @covers ::all
     * @test
     */
    public function test_all_method()
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
    public function test_paginate_method()
    {
        $this->assertTrue(false);
    }

    /**
     * @group repository
     * @covers ::create
     * @test
     */
    public function test_create_method()
    {
        $beforeCount = Foo::count();
        $this->repository->create( $this->getFoos(1) );
        $afterCount = Foo::count();

        $this->assertTrue( $beforeCount === ( $afterCount + 1 ) );
    }

    /**
     * @group repository
     * @covers ::update
     * @test
     */
    public function test_update_method()
    {
        $this->assertTrue(false);
    }

    /**
     * @group repository
     * @covers ::delete
     * @test
     */
    public function test_delete_method()
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
    public function test_forceDelete_method()
    {
        Foo::insert( $this->getFoos(5) );
        $beforeCount = Foo::count();

        $this->repository->forceDelete(3);

        $afterCount = Foo::count();
        $this->assertTrue( $beforeCount === ( $afterCount + 1 ) );
    }

    /**
     * @group repository
     * @covers ::find
     * @test
     */
    public function test_find_method()
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
    public function test_findBy_method()
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
    public function test_first_method()
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
    public function test_count_method()
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
    public function test_lists_method()
    {
        $this->assertTrue(false);
    }

   /**
     * @group repository
     * @covers ::setNestedData
     * @test
     */
    public function test_setNestedData_method()
    {
        $this->assertTrue(false);
    }

   /**
     * @group repository
     * @covers ::getNestedData
     * @test
     */
    public function test_getNestedData_method()
    {
        $this->assertTrue(false);
    }

   /**
     * @group repository
     * @covers ::applyNestedData
     * @test
     */
    public function test_applyNestedData_method()
    {
        $this->assertTrue(false);
    }

   /**
     * @group repository
     * @covers ::setQuery
     * @test
     */
    public function test_setQuery_method()
    {
        $this->assertTrue(false);
    }

   /**
     * @group repository
     * @covers ::getQuery
     * @test
     */
    public function test_getQuery_method()
    {
        $this->assertTrue(false);
    }

   /**
     * @group repository
     * @covers ::makeModel
     * @test
     */
    public function test_makeModel_method()
    {
        $this->assertTrue(false);
    }

   /**
     * @group repository
     * @covers ::setModel
     * @test
     */
    public function test_setModel_method()
    {
        $this->assertTrue(false);
    }

   /**
     * @group repository
     * @covers ::getModel
     * @test
     */
    public function test_getModel_method()
    {
        $this->assertTrue(false);
    }

   /**
     * @group repository
     * @covers ::getModelName
     * @test
     */
    public function test_getModelName_method()
    {
        $this->assertTrue(false);
    }

   /**
     * @group repository
     * @covers ::getCriteria
     * @test
     */
    public function test_getCriteria_method()
    {
        $this->assertTrue(false);
    }

   /**
     * @group repository
     * @covers ::pushCriteria
     * @test
     */
    public function test_pushCriteria_method()
    {
        $this->assertTrue(false);
    }

   /**
     * @group repository
     * @covers ::setOrder
     * @test
     */
    public function test_setOrder_method()
    {
        $this->assertTrue(false);
    }

   /**
     * @group repository
     * @covers ::setRows
     * @test
     */
    public function test_setRows_method()
    {
        $this->assertTrue(false);
    }

   /**
     * @group repository
     * @covers ::getRows
     * @test
     */
    public function test_getRows_method()
    {
        $this->assertTrue(false);
    }

   /**
     * @group repository
     * @covers ::setColumns
     * @test
     */
    public function test_setColumns_method()
    {
        $this->assertTrue(false);
    }

   /**
     * @group repository
     * @covers ::getColumns
     * @test
     */
    public function test_getColumns_method()
    {
        $this->assertTrue(false);
    }

   /**
     * @group repository
     * @covers ::applyCriteria
     * @test
     */
    public function test_applyCriteria_method()
    {
        $this->assertTrue(false);
    }
}