<?php

use Phinx\Migration\AbstractMigration;

class CreateFoosTable extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $foos = $this->table('foos');
        $foos
              ->addColumn('body', 'string', array('limit' => 255))
              ->addColumn('created_at', 'datetime')
              ->addColumn('updated_at', 'datetime')
              ->addColumn('deleted_at', 'datetime')
              ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {

    }

}
