<?php namespace WebConfection\Repositories;

use Illuminate\Container\Container as App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

use WebConfection\Repositories\Interfaces\ParameterInterface;

use WebConfection\Repositories\Exceptions\RepositoryException;
use WebConfection\Repositories\Traits\ParameterTrait;

abstract class Repository implements ParameterInterface {

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
    protected $model = null;

    /**
     * Array of criteria models to be applied to the query.
     *
     * @var array
     */
    protected $criteria = [];

    /**
     * Array of strings containing nested data requirements applied to 
     * the query.
     *
     * @var array
     */
    public $with = [];

    /**
     * The query property retrieved from the associated model.
     *
     * @var model
     */    
    public $query = null;

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

        $modelTraits = class_uses( $this->model );
        $this->softDeletes = array_key_exists( 'Illuminate\Database\Eloquent\SoftDeletes', $modelTraits );
    }

    /**
     * See WebConfection\Repositories\Interfaces\RepositoryInterface
     * 
     * @return string
     */
    abstract function model();
    
    /**
     * See WebConfection\Repositories\Interfaces\RepositoryInterface
     */
    public function all( $columns = ['*'], $withTrash = false )
    {
        $this->query = $this->model->newQuery (); // Create a new query object
        $this->applyCriteria (); // Apply any criteria
        $this->applyNestedDataRequirements (); // Include any nested data

        if( $withTrash && $this->softDeletes )
        {
            return $this->query->withTrashed()->get( $columns );
        }
        else
        {
            return $this->query->get( $columns );
        }
    }

    /**
     * See WebConfection\Repositories\Interfaces\RepositoryInterface
     */
    public function paginate( $rows = 10, $columns = ['*'], $withTrash = false )
    {
        $this->query = $this->model->newQuery(); // Create a new query object
        $this->applyCriteria(); // Apply any criteria
        $this->applyNestedDataRequirements(); // Include any nested data

        if( $withTrash && $this->softDeletes )
        {
            return $this->query->withTrashed()->paginate( $rows, $columns );    
        }
        else
        {
            return $this->query->paginate( $this->rows, $this->columns );
        }
    }

    /**
     * See WebConfection\Repositories\Interfaces\RepositoryInterface
     */
    public function find( $id, $columns = ['*'], $withTrash = false )
    {
        $this->query = $this->model->newQuery(); // Create a new query object
        $this->applyCriteria(); // Apply any criteria
        $this->applyNestedDataRequirements(); // Include any nested data

        if( $this->softDeletes && $withTrash )
        {
            return $this->query->withTrashed()->findOrFail( $id, $columns );
        }
        else
        {
            return $this->query->findOrFail( $id, $columns );
        }
    }

    /**
     * See WebConfection\Repositories\Interfaces\RepositoryInterface
     */
    public function findBy( array $attributes, $columns = ['*'], $withTrash = false ) 
    {
        $this->query = $this->model->newQuery(); // Create a new query object
        $this->applyCriteria(); // Apply any criteria
        $this->applyNestedDataRequirements(); // Include any nested data

        foreach( $attributes as $key => $value )
        {
            $this->query->where( $key, '=', $value )->first( $this->columns );    
        }

        if( $this->softDeletes && $withTrash )
        {
            return $this->query->withTrashed()->first( $columns );
        }
        else
        {
            return $this->query->first( $columns );
        }
    }

    /**
     * See WebConfection\Repositories\Interfaces\RepositoryInterface
     */
    public function first( $columns = ['*'], $withTrash = flase ) 
    {
        $this->query = $this->model->newQuery(); // Create a new query object
        $this->applyCriteria(); // Apply any criteria
        $this->applyNestedDataRequirements(); // Include any nested data

        if( $this->softDeletes && $withTrash )
        {
            return $this->query->withTrashed()->first( $columns );
        }
        else
        {
            return $this->query->first( $columns );
        }
    }

    /**
     * See WebConfection\Repositories\Interfaces\RepositoryInterface
     */
    public function count( $withTrash = false )
    {
        $this->query = $this->model->newQuery(); // Create a new query object
        $this->applyCriteria(); // Apply any criteria
        $this->applyNestedDataRequirements(); // Include any nested data

        if( $this->softDeletes && $withTrash )
        {
            return $this->query->withTrashed()->count();
        }
        else
        {
            return $this->query->count();
        }
    }

    /**
     * See WebConfection\Repositories\Interfaces\RepositoryInterface
     */
    public function create( array $data ) 
    {
        return $this->model->create( $data );
    }

    /**
     * See WebConfection\Repositories\Interfaces\RepositoryInterface
     */
    public function update( $id, array $data ) 
    {
        return $this->model->findOrFail( $id )->update( $data );
    }

    /**
     * See WebConfection\Repositories\Interfaces\RepositoryInterface
     */
    public function delete( $id )
    {
        return $this->model->findOrFail( $id )->destroy( $id );
    }

    /**
     * See WebConfection\Repositories\Interfaces\RepositoryInterface
     */
    public function forceDelete( $id )
    {   
        return $this->model->findOrFail( $id )->forceDelete( $id );
    }

    /**
     * See WebConfection\Repositories\Interfaces\RepositoryInterface
     */
    private function applyNestedDataRequirements()
    {
        foreach( $this->with as $nested )
        {
            $this->query = $this->query->with( $nested );
        }

        return $this;   
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
            throw new RepositoryException("Class {$this->model} must be an instance of Illuminate\\Database\\Eloquent\\Model");

        $this->model = $model;

        return $this;
    }

    /**
     * Return the name of the current class without it's namespacing.
     *
     * @return  string
     */
    private function getModelName()
    {
      $function = new \ReflectionClass( $this->model );      
      return $function->getShortName();
    }

    /**
     * Apply the criteria to the current query.
     * 
     * @return $this
     */
    private function applyCriteria()
    {
        foreach( $this->criteria as $criterion )
        {
            $this->query = $criterion->apply( $this->query, $this );
        }

        return $this;
    }
}