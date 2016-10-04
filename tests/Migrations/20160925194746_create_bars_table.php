<?php

use Phinx\Migration\AbstractMigration;

class CreateBarsTable extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $bars = $this->table('bars');
        $bars
              ->addColumn('foo_id', 'integer')
              ->addColumn('body', 'string', ['limit' => 255])
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
