<?php namespace WebConfection\LaravelRepo\Repositories;

use Illuminate\Container\Container as App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

use WebConfection\LaravelRepo\Interfaces\AbstractInterface;
use WebConfection\LaravelRepo\Exceptions\RepositoryException;
use WebConfection\LaravelRepo\Traits\ParameterTrait;



abstract class AbstractRepository {

    use ParameterTrait;
    
    /**
     * @var Illuminate\Container\Container
     */
    private $app;

    /**
     * Instance of the model associated to the current repository.
     *
     * @var Illuminate\Database\Eloquent\Model
     */
    private $model = null;

    /**
     * Array of criteria models to be applied to the query.
     *
     * @var array
     */
    private $criteria = [];

    /**
     * Array of strings containing nested data requirements applied to 
     * the query.
     *
     * @var array
     */
    private $nestedData = [];

    /**
     * The query property retrieved from the associated model.
     *
     * @var model
     */    
    private $query = null;

    /**
     * Flag to deltermine of the current model uses the softDelete trait enabling us to
     * retrieved "trashed" data.
     *
     * @var boolean
     */    
    protected $softdeletes = false;
    
    /**
     * Must be called by any repository that extends this class.
     *
     * @param  Illuminate\Container\Container $app
     * @return  void
     */
    public function __construct( App $app ){

        $this->app = $app;
        $this->makeModel();

        $modelTraits = class_uses( $this->getModel() );
        $this->softDeletes = array_key_exists( 'Illuminate\Database\Eloquent\SoftDeletes', $modelTraits );
    }

    /**
     * See HomeBargain\Illuminate\Interfaces\AbstractInterface
     * 
     * @return string
     */
    abstract function model();
    
    /**
     * See HomeBargain\Illuminate\Interfaces\AbstractInterface
     */
    public function all( $columns = array('*'), $withTrash = false )
    {
        $this->applyCriteria(); // Apply any criteria
        $this->applyNestedData(); // Include any nested data

        if( $withTrash && $this->softDeletes )
        {
            return $this->getQuery()->withTrashed()->get( $columns );
        }
        else
        {
            return $this->getQuery()->get( $columns );
        }
    }

    /**
     * See HomeBargain\Illuminate\Interfaces\AbstractInterface
     */
    public function paginate( $rows = 10, $columns = array('*'), $withTrash = false )
    {
        $this->applyCriteria(); // Apply any criteria
        $this->applyNestedData(); // Include any nested data

        if( $withTrash && $this->softDeletes )
        {
            return $this->getQuery()->withTrashed()->paginate( $rows, $columns );    
        }
        else
        {
            return $this->getQuery()->paginate( $rows, $columns );
        }
    }

    /**
     * See HomeBargain\Illuminate\Interfaces\AbstractInterface
     */
    public function create( array $data ) 
    {
        return $this->setModel( $this->getModel()->create( $data ) );
    }

    /**
     * See HomeBargain\Illuminate\Interfaces\AbstractInterface
     */
    public function update( $id, array $data ) 
    {
        $this->setModel( $this->getModel()->findOrFail( $id ) );

        return $this->getModel()->update( $data );
    }

    /**
     * See HomeBargain\Illuminate\Interfaces\AbstractInterface
     */
    public function delete( $id )
    {
        return $this->getModel()->findOrFail( $id )->destroy( $id );
    }

    /**
     * See HomeBargain\Illuminate\Interfaces\AbstractInterface
     */
    public function forceDelete( $id )
    {
        return $this->getModel()->findOrFail( $id )->forceDelete( $id );
    }

    /**
     * See HomeBargain\Illuminate\Interfaces\AbstractInterface
     */
    public function find( $id, $columns = array('*') )
    {
        $this->setQuery( $this->getModel()->newQuery() ); // Fresh query
        $this->applyNestedData(); // Include any nested data

        if( $this->softDeletes )
        {
            return $this->getQuery()->withTrashed()->findOrFail( $id, $columns );
        }
        else
        {
            return $this->getQuery()->findOrFail( $id, $columns );
        }
    }

    /**
     * See HomeBargain\Illuminate\Interfaces\AbstractInterface
     */
    public function findBy( $attribute, $value, $columns = array('*') ) 
    {
        $this->setQuery( $this->getModel()->newQuery() );
        $this->applyNestedData(); // Include any nested data
        return $this->getQuery()->where( $attribute, '=', $value )->first( $columns );
    }

    /**
     * See HomeBargain\Illuminate\Interfaces\AbstractInterface
     */
    public function first( $columns = array('*') ) 
    {
        $this->applyCriteria(); // Apply any criteria
        $this->applyNestedData(); // Include any nested data

        return $this->getQuery()->first( $columns );
    }

    /**
     * See HomeBargain\Illuminate\Interfaces\AbstractInterface
     */
    public function count()
    {
        $this->applyCriteria(); // Apply any criteria

        return $this->getQuery()->count();
    }

    /**
     * See HomeBargain\Illuminate\Interfaces\AbstractInterface
     */
    public function lists($value, $key, $distinct = false )
    {
        $this->applyCriteria();

        if( $distinct )
        {
            return $this->getQuery()->distinct()->lists( $value, $key );  
        }
        else
        {
            return $this->getQuery()->lists( $value, $key );
        }
    }

    /**
     * See HomeBargain\Illuminate\Interfaces\AbstractInterface
     */
    public function setNestedData( array $nestedData )
    {
        $this->nestedData = $nestedData;

        return $this;
    }

    /**
     * See HomeBargain\Illuminate\Interfaces\AbstractInterface
     */
    public function getNestedData()
    {
        return $this->nestedData;
    }

    /**
     * See HomeBargain\Illuminate\Interfaces\AbstractInterface
     */
    private function applyNestedData()
    {
        foreach( $this->getNestedData() as $nestedData )
        {
            $this->setQuery( $this->getQuery()->with( $nestedData ) );
        }

        return $this;   
    }

    /**
     * See HomeBargain\Illuminate\Interfaces\AbstractInterface
     */
    public function setQuery( Builder $query )
    {
      $this->query = $query;

      return $this;
    }

    /**
     * See HomeBargain\Illuminate\Interfaces\AbstractInterface
     */
    public function getQuery()
    {
      return $this->query;
    }

    /**
     * Create an instance of the associated model
     * 
     * @return $this
     * @throws RepositoryException
     */
    private function makeModel() {
        
        $model = $this->app->make( $this->model() );
 
        if ( !$model instanceof Model )
            throw new RepositoryException("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");

        $this->setModel( $model );

        return $this;
    }

    /**
     * Standard setter
     * 
     * @param \Illuminate\Database\Eloquent\Model
     * @return  $this
     */
    private function setModel( Model $model )
    {
      $this->model = $model;

      return $this;
    }

    /**
     * See HomeBargain\Illuminate\Interfaces\AbstractInterface
     */
    public function getModel()
    {
      return $this->model;
    }

    /**
     * Return the name of the current class without it's namespacing.
     *
     * @return  string
     */
    public function getModelName()
    {
      $function = new \ReflectionClass( $this->model() );      
      return $function->getShortName();
    }

    /**
     * Standard getter
     * 
     * @return mixed
     */
    public function getCriteria() 
    {
        return $this->criteria;
    }
        
    /**
     * Push criteria onto the class property
     * 
     * @param Criteria $criteria
     * @return $this
     */
    public function pushCriteria( $criteria ) 
    {
        array_push( $this->criteria, $criteria );

        return $this;
    }

    /**
     * Apply the criteria to the current query.
     * 
     * @return $this
     */
    private function applyCriteria()
    {
        $this->setQuery( $this->getModel()->newQuery() );

        foreach( $this->getCriteria() as $criteria ) 
        {
            $this->setQuery( $criteria->apply( $this->getQuery(), $this) );
        }

        return $this;
    }
}