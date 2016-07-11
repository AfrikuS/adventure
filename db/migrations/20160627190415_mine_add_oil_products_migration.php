<?php

use Phinx\Migration\AbstractMigration;

class MineAddOilProductsMigration extends AbstractMigration
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
        $miners = $this->table('mine_miners');

        if (!$miners->hasColumn('masut')) {
            $miners
                ->addColumn('masut', 'integer', ['null' => false, 'signed' => false])
                ->addColumn('lubricant', 'integer', ['null' => false, 'signed' => false])
                ->addColumn('drill', 'integer', ['null' => false, 'signed' => false])
                ->addColumn('accelerator', 'integer', ['null' => false, 'signed' => false])
                ->addColumn('cleaner', 'integer', ['null' => false, 'signed' => false])
                ->addColumn('catalyst', 'integer', ['null' => false, 'signed' => false])
                ->addColumn('solvent', 'integer', ['null' => false, 'signed' => false])
                ->addColumn('naphtha', 'integer', ['null' => false, 'signed' => false])
                ->addColumn('benzine', 'integer', ['null' => false, 'signed' => false])
                ->addColumn('heater', 'integer', ['null' => false, 'signed' => false])
                ->addColumn('chark', 'integer', ['null' => false, 'signed' => false])
                ->addColumn('distiller', 'integer', ['null' => false, 'signed' => false])
            ->update();
        }
    }

    public function down()
    {
        $table = $this->table('mine_miners');
        $table
            ->removeColumn('masut')
            ->removeColumn('lubricant')
            ->removeColumn('drill')
            ->removeColumn('accelerator')
            ->removeColumn('cleaner')
            ->removeColumn('catalyst')
            ->removeColumn('solvent')
            ->removeColumn('naphtha')
            ->removeColumn('benzine')
            ->removeColumn('heater')
            ->removeColumn('distiller')
            ->removeColumn('chark')
        ->update();
    }
}
