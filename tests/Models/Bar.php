<?php namespace WebConfection\Repositories\Tests\Models;

use Illuminate\Database\Eloquent\Model;

class Bar extends Model {

    /**
     * @var string
     *
     * The table for the model.
     */
    protected $table = 'bars';

    /**
     * WebConfection\Repositories\Tests\Models\Foo associated to the current Bar.
     *
     * @return WebConfection\Repositories\Tests\Models\Foo
     */
    public function foo()
    {
        return $this->belongsTo(Foo::class);
    } 
}