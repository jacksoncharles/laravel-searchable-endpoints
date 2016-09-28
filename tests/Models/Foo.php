<?php namespace WebConfection\Repositories\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

use WebConfection\Repositories\Tests\Models\Bar;

class Foo extends Model {

    use SoftDeletes;
    
    /**
     * @var string
     *
     * The table for the model.
     */
    protected $table = 'foos';

    /**
     * WebConfection\Repositories\Tests\Models\Bar associated to the current Foo.
     *
     * @return WebConfection\Repositories\Tests\Models\Bar
     */
    public function bars()
    {
        return $this->hasMany(Bar::class);
    }     

}