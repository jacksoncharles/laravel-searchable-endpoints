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

    public function setUp() 
    {

        $this->createDatabaseConnection();
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
}