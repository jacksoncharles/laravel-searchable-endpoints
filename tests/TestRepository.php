<?php

require __DIR__.'/../vendor/autoload.php';

use HomeBargain\LaravelRepositories\Repositories\AbstractRepository;

class TestRepository extends AbstractRepository {

    public function __construct( $model )
    {
        $this->setModel( $model );
        parent::__construct();        
    }
}