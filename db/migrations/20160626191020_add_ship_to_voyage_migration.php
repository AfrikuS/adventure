<?php

use Phinx\Migration\AbstractMigration;

class AddShipToVoyageMigration extends AbstractMigration
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
    public function change()
    {
        $shipsTable = $this->table('geo_trader_ships');
        $voyagesTable = $this->table('geo_travel_voyages');

        $existShipColumn = $voyagesTable->hasColumn('ship_id');

        if (!$existShipColumn) {
            $voyagesTable->addColumn('ship_id', 'integer', ['null' => false, 'signed' => false])
                ->addForeignKey('ship_id', $shipsTable, ['id'])
                ->update();
        }
    }
}
