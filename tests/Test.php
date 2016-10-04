<?php namespace WebConfection\Repositories\Tests;

use Illuminate\Container\Container as App;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;

use \PHPUnit_Framework_TestCase as TestCase;

/**
 * @coversDefaultClass \WebConfection\Repositories\Repository
 */
class Test extends TestCase {

    protected $mock;

    protected $repository;

    private $foos;

    private $bars;

    private $faker;

    public function setUp() 
    {
        $this->createDatabaseConnection();
        
        $this->faker = \Faker\Factory::create();

        $this->foos = [
            [
                'body'          =>  'Foo1',
                'created_at'    =>  $this->faker->dateTimeThisYear()
            ],
            [
                'body'          =>  'Foo2',
                'created_at'    =>  $this->faker->dateTimeThisYear()
            ],
            [
                'body'          =>  'Foo3',
                'created_at'    =>  $this->faker->dateTimeThisYear()
            ],
            [
                'body'          =>  'Foo4',
                'created_at'    =>  $this->faker->dateTimeThisYear()
            ],
            [
                'body'          =>  'Foo5',
                'created_at'    =>  $this->faker->dateTimeThisYear()
            ]
        ];

        $this->bars = [
            [
                'foo_id'        =>  1,
                'body'          =>  'Bar1',
                'created_at'    =>  $this->faker->dateTimeThisYear()
            ],
            [
                'foo_id'        =>  2,
                'body'          =>  'Bar2',
                'created_at'    =>  $this->faker->dateTimeThisYear()
            ],
            [
                'foo_id'        =>  3,
                'body'          =>  'Bar3',
                'created_at'    =>  $this->faker->dateTimeThisYear()
            ],
            [
                'foo_id'        =>  4,
                'body'          =>  'Bar4',
                'created_at'    =>  $this->faker->dateTimeThisYear()
            ],
            [
                'foo_id'        =>  5,
                'body'          =>  'Bar5',
                'created_at'    =>  $this->faker->dateTimeThisYear()
            ]
        ];
    }
    
    protected function createDatabaseConnection()
    {
        $capsule = new Capsule;

        $capsule->addConnection([
            'driver' => 'sqlite',
            'database' => 'tests/database.sqlite',
            'prefix' => ''
        ]);

        // Set the event dispatcher used by Eloquent models... (optional)
        $capsule->setEventDispatcher(new Dispatcher(new Container));

        // Make this Capsule instance available globally via static methods... (optional)
        $capsule->setAsGlobal();

        // Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
        $capsule->bootEloquent();        
    }

    protected function getFoos( $rows )
    {
        $foos = $this->foos;
        return array_slice( $foos, 0, $rows );
    }

    protected function getBars( $rows )
    {
        $bars = $this->bars;
        return array_slice( $bars, 0, $rows );
    }
    
}