<?php namespace WebConfection\Repositories\Tests;

use Illuminate\Container\Container as App;

use WebConfection\Repositories\Tests\Test;
use WebConfection\Repositories\Tests\Models\Foo;
use WebConfection\Repositories\Tests\Models\Bar;

class ParameterTest extends Test {

    public function setUp() 
    {
        parent::setUp();

        $this->repository = new \Webconfection\Repositories\Tests\Repositories\FooRepository( new App );

        Foo::truncate();
        Foo::insert( $this->getFoos(5) );
    }

    /**
     * @group criteria
     * @covers \WebConfection\Repositories\Criteria\BetweenParameter
     * @test
     */
    public function test_between_parameter()
    {
        $this->assertTrue(false);
    }

    /**
     * @group criteria
     * @covers \WebConfection\Repositories\Criteria\EqualsParameter
     * @test
     */
    public function test_equals_parameter()
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
     * @covers \WebConfection\Repositories\Criteria\GreaterThanParameter
     * @test
     */
    public function test_greater_than_parameter()
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
     * @covers \WebConfection\Repositories\Criteria\GreaterThanEqualsParameter
     * @test
     */
    public function test_greater_than_equals_parameter()
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
     * @covers \WebConfection\Repositories\Criteria\InArrayParameter
     * @test
     */
    public function test_in_array_parameter()
    {
        $this->assertTrue(false);
    }

    /**
     * @group criteria
     * @covers \WebConfection\Repositories\Criteria\LessThanParameter
     * @test
     */
    public function test_less_than_parameter()
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
     * @covers \WebConfection\Repositories\Criteria\LessThanEqualsParameter
     * @test
     */
    public function test_less_than_equals_parameter()
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
     * @covers \WebConfection\Repositories\Criteria\LikeParameter
     * @test
     */
    public function test_like_parameter()
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
     * @covers \WebConfection\Repositories\Criteria\NotLikeParameter
     * @test
     */
    public function test_not_like_parameter()
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
     * @covers \WebConfection\Repositories\Criteria\OrEqualsParameter
     * @test
     */
    public function test_or_equals_parameter()
    {
       $results = $this->repository->setParameters([
            'or_equal' => [
                'id' => [
                    '1',
                    '3'
                ]
            ]
        ])
        ->setOrder(['id' => 'ASC'])
        ->all();
        
        $this->assertTrue( count( $results ) === 2 );
        for ( $x = 0; $x < 3; $x++ )
        {
            $this->assertTrue( $results[$x]->id == ( $x + 1 ) );
        }
    }

    /**
     * @group criteria
     * @covers \WebConfection\Repositories\Criteria\OrLikeParameter
     * @test
     */
    public function test_or_like_parameter()
    {
        $this->assertTrue(false);
    }

}