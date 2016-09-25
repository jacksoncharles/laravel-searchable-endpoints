<?php

use \WebConfection\Repositories\Tests\Migrations\Migration;

class CreateFoobarsTable extends Migration
{
    public function up()
    {
        $this->schema->create('foobars', function(Illuminate\Database\Schema\Blueprint $table)
        {
            // Auto-increment id
            $table->increments('id');
            $table->string('name', 255);
            $table->timestamps();
        });
    }

    public function down()
    {
        $this->schema->drop('foobars');
    }
}
