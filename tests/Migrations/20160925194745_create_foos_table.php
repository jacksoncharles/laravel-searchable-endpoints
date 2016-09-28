<?php

use Phinx\Migration\AbstractMigration;

class CreateFoosTable extends AbstractMigration
{
    /**
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */

    /**
     * Migrate Up.
     */
    public function up()
    {
        $foobars = $this->table('foos');
        $foobars
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
