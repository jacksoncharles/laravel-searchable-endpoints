<?php namespace WebConfection\Repositories\Tests;

use Illuminate\Container\Container as App;

use \WebConfection\Repositories\Tests\Test;
use WebConfection\Repositories\Tests\Models\Foo;
use WebConfection\Repositories\Tests\Models\Bar;

class CriteriaTest extends Test {

    public function setUp() 
    {
        parent::setUp();

        $this->repository = new \Webconfection\Repositories\Tests\Repositories\FooRepository( new App );
        Foo::truncate();
        Foo::insert( $this->getFoos(5) );
        Bar::insert( $this->getBars(5) );
    }

    /**
     * @group criteria
     * @covers \WebConfection\Repositories\Repository\applyNestedCriteria
     * @test
     */
    public function is_with_criterion_working()
    {

        $result = $this->repository->setParameters([
            'equal' => [
                'id' => [
                    1
                ]
            ],
            'with' => [
                'bars'
            ]
        ])->first()->toArray();

        $this->assertTrue( isSet( $result['id'] ) );
        $this->assertTrue( $result['id'] == 1 );

        $this->assertTrue( isSet( $result['bars'] ) );
    }

    /**
     * @group criteria
     * @covers \WebConfection\Repositories\Criteria\BetweenCriteria
     * @test
     */
    public function is_between_criterion_working()
    {
        $keys = [2,5];

        $results = $this->repository->setParameters([
            'between' => [
                'id' => $keys
            ]
        ])->all();

        $this->assertTrue( count( $results ) === 2 );

        for ( $x = 0; $x < 2; $x++ )
        {
            $this->assertTrue( in_array( $results[$x]->id, [3,4] ) );
        }
    }

    /**
     * @group criteria
     * @covers \WebConfection\Repositories\Criteria\OrderByCriteria
     * @test
     */
    public function is_order_by_criterion_working()
    {
        $results = $this->repository->setParameters([
            'order_by' => [
                'id' => 'DESC'
            ]
        ])->all();
        
        $counter = 5;

        foreach ( $results as $result )
        {
            $this->assertTrue( $result->id === $counter );
            $counter--;
        }

        
    }

    /**
     * @group criteria
     * @covers \WebConfection\Repositories\Criteria\EqualsCriteria
     * @test
     */
    public function is_equal_criterion_working()
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
    public function is_greater_than_criterion_working()
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
    public function is_greater_than_equals_criterion_working()
    {

       $results = $this->repository->setParameters([
            'gte' => [
                'id' => [
                    3
                ]
            ],
            'order_by' => [
                'id' => 'ASC'
            ]
        ])
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
    public function is_in_array_criterion_working()
    {
        $keys = [5,1,3];

        $results = $this->repository->setParameters([
            'in_array' => [
                'id' => $keys
            ],
            'order_by' => [
                'id' => 'ASC'
            ]
        ])
        ->all();
        
        $this->assertTrue( count( $results ) === 3 );

        for ( $x = 0; $x < 3; $x++ )
        {
            $this->assertTrue( in_array( $results[$x]->id, $keys ) );
        }
    }

    /**
     * @group criteria
     * @covers \WebConfection\Repositories\Criteria\LessThanCriteria
     * @test
     */
    public function is_less_than_criterion_working()
    {
       $results = $this->repository->setParameters([
            'lt' => [
                'id' => [
                    3
                ]
            ],
            'order_by' => [
                'id' => 'ASC'
            ]            
        ])
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
    public function is_less_than_equals_criterion_working()
    {
       $results = $this->repository->setParameters([
            'lte' => [
                'id' => [
                    3
                ]
            ],
            'order_by' => [
                'id' => 'ASC'
            ]            
        ])
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
    public function is_like_criterion_working()
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
    public function is_not_like_criterion_working()
    {
       $results = $this->repository->setParameters([
            'not_like' => [
                'body' => [
                    'Foo5'
                ]
            ],
            'order_by' => [
                'id' => 'ASC'
            ]            
        ])
        ->all();
        
        $this->assertTrue( count( $results ) === 4 );
        for ( $x = 0; $x < 4; $x++ )
        {
            $this->assertTrue( $results[$x]->id == ( $x + 1 ) );
        }
    }

    /**
     * @group criteria
     * @covers \WebConfection\Repositories\Criteria\OrEqualsCriteria
     * @tessst
     */
    public function is_or_equal_criterion_working()
    {
        $keys = [1,3];

        $results = $this->repository->setParameters([
            'or_equal' => [
                'id' => $keys
            ],
            'order_by' => [
                'id' => 'ASC'
            ]            
        ])
        ->all();
        
        $this->assertTrue( count( $results ) === 2 );
        for ( $x = 0; $x < 3; $x++ )
        {
            $this->assertTrue( in_array( $results[$x]->id, $keys ) );
        }
    }

    /**
     * @group criteria
     * @covers \WebConfection\Repositories\Criteria\OrLikeCriteria
     * @test
     */
    public function is_or_like_criterion_working()
    {
        $keys = [1,3];

        $results = $this->repository->setParameters([
            'or_like' => [
                'id' => $keys
            ],
            'order_by' => [
                'id' => 'ASC'
            ]            
        ])
        ->all();
        
        $this->assertTrue( count( $results ) === 2 );
        for ( $x = 0; $x < 2; $x++ )
        {
            $this->assertTrue( in_array( $results[$x]->id,  $keys ) );
        }
    }
}