<?php namespace WebConfection\Repositories;

use Illuminate\Container\Container as App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

use WebConfection\Repositories\Interfaces\RepositoryInterface;
use WebConfection\Repositories\Interfaces\ParameterInterface;

use WebConfection\Repositories\Exceptions\RepositoryException;
use WebConfection\Repositories\Traits\ParameterTrait;

abstract class Repository implements RepositoryInterface, ParameterInterface {

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
     * The number of rows in a paginated list
     *
     * @var integer
     */    
    public $rows = 10;

    /**
     * The columns to be returned
     *
     * @var string
     */    
    private $columns = ['*'];

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
     * See WebConfection\Illuminate\Interfaces\AbstractInterface
     * 
     * @return string
     */
    abstract function model();
    
    /**
     * See WebConfection\Illuminate\Interfaces\AbstractInterface
     */
    public function all( $withTrash = false )
    {
        $this->query = $this->model->newQuery (); // Create a new query object
        $this->applyCriteria (); // Apply any criteria
        $this->applyNestedDataRequirements (); // Include any nested data

        

        if( $withTrash && $this->softDeletes )
        {
            return $this->query->withTrashed()->get( $this->columns );
        }
        else
        {
            return $this->query->get( $this->columns );
        }
    }

    /**
     * See WebConfection\Illuminate\Interfaces\AbstractInterface
     */
    public function paginate( $withTrash = false )
    {
        $this->query = $this->model->newQuery(); // Create a new query object
        $this->applyCriteria(); // Apply any criteria
        $this->applyNestedDataRequirements(); // Include any nested data

        if( $withTrash && $this->softDeletes )
        {
            return $this->query->withTrashed()->paginate( $this->rows, $this->columns );    
        }
        else
        {
            return $this->query->paginate( $this->rows, $this->columns );
        }
    }

    /**
     * See WebConfection\Illuminate\Interfaces\AbstractInterface
     */
    public function find( $id )
    {
        $this->query = $this->model->newQuery(); // Create a new query object
        $this->applyCriteria(); // Apply any criteria
        $this->applyNestedDataRequirements(); // Include any nested data

        if( $this->softDeletes )
        {
            return $this->query->withTrashed()->findOrFail( $id, $this->columns );
        }
        else
        {
            return $this->query->findOrFail( $id, $this->columns );
        }
    }

    /**
     * See WebConfection\Illuminate\Interfaces\AbstractInterface
     */
    public function findBy( array $attributes ) 
    {
        $this->query = $this->model->newQuery(); // Create a new query object
        $this->applyCriteria(); // Apply any criteria
        $this->applyNestedDataRequirements(); // Include any nested data

        foreach( $attributes as $key => $value )
        {
            $this->query->where( $key, '=', $value )->first( $this->columns );    
        }

        return $this->query->first();
    }

    /**
     * See WebConfection\Illuminate\Interfaces\AbstractInterface
     */
    public function first() 
    {
        $this->query = $this->model->newQuery(); // Create a new query object
        $this->applyCriteria(); // Apply any criteria
        $this->applyNestedDataRequirements(); // Include any nested data

        return $this->query->first( $this->columns );
    }

    /**
     * See WebConfection\Illuminate\Interfaces\AbstractInterface
     */
    public function count()
    {
        $this->query = $this->model->newQuery(); // Create a new query object
        $this->applyCriteria(); // Apply any criteria
        $this->applyNestedDataRequirements(); // Include any nested data

        return $this->query->count();
    }

    /**
     * See WebConfection\Illuminate\Interfaces\AbstractInterface
     */
    public function lists( $key, $value )
    {
        $this->query = $this->model->newQuery(); // Create a new query object
        $this->applyCriteria(); // Apply any criteria
        $this->applyNestedDataRequirements(); // Include any nested data

        $this->columns = [$value,$key];
        
        $response = [];

        $results = $this->query->get( $this->columns )->toArray();

        foreach( $results as $result )
        {

            $response[$result[$key]] = $result[$value];
        }

        return $response;
    }

    /**
     * See WebConfection\Illuminate\Interfaces\AbstractInterface
     */
    public function create( array $data ) 
    {
        return $this->model->create( $data );
    }

    /**
     * See WebConfection\Illuminate\Interfaces\AbstractInterface
     */
    public function update( $id, array $data ) 
    {
        return $this->model->findOrFail( $id )->update( $data );
    }

    /**
     * See WebConfection\Illuminate\Interfaces\AbstractInterface
     */
    public function delete( $id )
    {
        return $this->model->findOrFail( $id )->destroy( $id );
    }

    /**
     * See WebConfection\Illuminate\Interfaces\AbstractInterface
     */
    public function forceDelete( $id )
    {   
        return $this->model->findOrFail( $id )->forceDelete( $id );
    }

    /**
     * See WebConfection\Illuminate\Interfaces\AbstractInterface
     */
    private function applyNestedDataRequirements()
    {
        foreach( $this->with as $nested )
        {
            $this->query = $this->query->with( $with );
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