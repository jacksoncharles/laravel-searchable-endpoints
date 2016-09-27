<?php namespace WebConfection\Repositories\Tests;

use Illuminate\Container\Container as App;

use WebConfection\Repositories\Tests\Test;
use WebConfection\Repositories\Tests\Models\Foo;
use WebConfection\Repositories\Tests\Models\Bar;

class CriteriaTest extends Test {

    public function setUp() 
    {
        parent::setUp();

        $this->repository = new \Webconfection\Repositories\Tests\Repositories\FooRepository( new App );

        Foo::truncate();
        Foo::insert( $this->getFoos(5) );
    }

    /**
     * @group criteria
     * @covers \WebConfection\Repositories\Criteria\BetweenCriteria
     * @test
     */
    public function test_between_criteria()
    {
        $this->assertTrue(false);
    }

    /**
     * @group criteria
     * @covers \WebConfection\Repositories\Criteria\EqualsCriteria
     * @test
     */
    public function test_equals_criteria()
    {
        $result = $this->repository->setParameters([
            'equal' => [
                'id' => [
                    3                
                ]
            ]
        ])->first();
        
        $this->assertTrue( $result->id === 3 );
    }

    /**
     * @group criteria
     * @covers \WebConfection\Repositories\Criteria\GreaterThanCriteria
     * @test
     */
    public function test_greater_than_criteria()
    {
        $result = $this->repository->setParameters([
            'gt' => [
                'id' => [
                    3                
                ]
            ]
        ])->all();
        
        $this->assertTrue( count( $result ) === 2 );
    }

    /**
     * @group criteria
     * @covers \WebConfection\Repositories\Criteria\GreaterThanEqualsCriteria
     * @test
     */
    public function test_greater_than_equals_criteria()
    {

       $results = $this->repository->setParameters([
            'gte' => [
                'id' => [
                    3
                ]
            ]
        ])
        ->setOrder(['id' => 'ASC'])
        ->all();
        
        $this->assertTrue( count( $results ) === 3 );
        for ( $x = 0; $x < 3; $x++ )
        {
            $this->assertTrue( $results[$x]->id == ( $x + 3 ) );
        }
    }

    /**
     * @group criteria
     * @covers \WebConfection\Repositories\Criteria\InArrayCriteria
     * @test
     */
    public function test_in_array_criteria()
    {
        $this->assertTrue(false);
    }

    /**
     * @group criteria
     * @covers \WebConfection\Repositories\Criteria\LessThanCriteria
     * @test
     */
    public function test_less_than_criteria()
    {
       $results = $this->repository->setParameters([
            'lt' => [
                'id' => [
                    3
                ]
            ]
        ])
        ->setOrder(['id' => 'ASC'])
        ->all();
        
        $this->assertTrue( count( $results ) === 2 );
        for ( $x = 1; $x < 3; $x++ )
        {
            $this->assertTrue( $results[$x-1]->id == $x );
        }
    }

    /**
     * @group criteria
     * @covers \WebConfection\Repositories\Criteria\LessThanEqualsCriteria
     * @test
     */
    public function test_less_than_equals_criteria()
    {
       $results = $this->repository->setParameters([
            'lte' => [
                'id' => [
                    3
                ]
            ]
        ])
        ->setOrder(['id' => 'ASC'])
        ->all();
        
        $this->assertTrue( count( $results ) === 3 );
        for ( $x = 1; $x < 4; $x++ )
        {
            $this->assertTrue( $results[$x-1]->id == $x );
        }
    }

    /**
     * @group criteria
     * @covers \WebConfection\Repositories\Criteria\LikeCriteria
     * @test
     */
    public function test_like_criteria()
    {
        $result = $this->repository->setParameters([
            'like' => [
                'body' => [
                    'Foo3'                
                ]
            ]
        ])->first();
        
        $this->assertTrue( $result->id === 3 );
    }

    /**
     * @group criteria
     * @covers \WebConfection\Repositories\Criteria\NotLikeCriteria
     * @test
     */
    public function test_not_like_criteria()
    {
       $results = $this->repository->setParameters([
            'not_like' => [
                'body' => [
                    'Foo5'
                ]
            ]
        ])
        ->setOrder(['id' => 'ASC'])
        ->all();
        
        $this->assertTrue( count( $results ) === 4 );
        for ( $x = 0; $x < 4; $x++ )
        {
            $this->assertTrue( $results[$x]->id == ( $x + 1 ) );
        }
    }

    /**
     * @group criteria
     * @covers \WebConfection\Repositories\Criteria\OrderByCriteria
     * @test
     */
    public function test_order_by_criteria()
    {
        ////
        /// FAILING!!!!
        /// 
        $result = $this->repository->setOrder(['id' => 'ASC'])->first();
        $this->assertTrue( $result->id === 1 );

        $result = $this->repository->setOrder(['id' => 'DESC'])->first();

        $this->assertTrue( $result->id === 5 );
    }

    /**
     * @group criteria
     * @covers \WebConfection\Repositories\Criteria\OrEqualsCriteria
     * @test
     */
    public function test_or_equals_criteria()
    {
        $this->assertTrue(false);
    }

    /**
     * @group criteria
     * @covers \WebConfection\Repositories\Criteria\OrLikeCriteria
     * @test
     */
    public function test_or_like_criteria()
    {
        $this->assertTrue(false);
    }

}