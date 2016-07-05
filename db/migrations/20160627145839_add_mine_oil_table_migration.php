<?php

use Phinx\Migration\AbstractMigration;

class AddMineOilTableMigration extends AbstractMigration
{
    /**
     * Change Method.
     *
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
    public function up()
    {
        if (!$this->hasTable('mine_miners')) {
            $users = $this->table('users');
            $miners = $this->table('mine_miners');

            $miners
                ->addColumn('petrol',   'integer', ['null' => false, 'signed' => false])
                ->addColumn('kerosene', 'integer', ['null' => false, 'signed' => false])
                ->addColumn('oil',      'integer', ['null' => false, 'signed' => false])
                ->addColumn('whater',   'integer', ['null' => false, 'signed' => false])
                ->create();
            
            $miners
                ->changeColumn('id', 'integer', ['null' => false, 'signed' => false])
                ->addForeignKey('id', $users, 'id')
                ->update();

        }
    }

    public function down()
    {
        if ($this->hasTable('mine_miners')) {
            $this->table('mine_miners')->drop();
        }
    }
}
