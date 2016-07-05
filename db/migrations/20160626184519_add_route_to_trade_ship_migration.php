<?php

use Phinx\Migration\AbstractMigration;

class AddRouteToTradeShipMigration extends AbstractMigration
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
        $routesTable = $this->table('geo_travel_routes');

        $existRouteColumn = $shipsTable->hasColumn('route_id');

        if (!$existRouteColumn) {
            $shipsTable->addColumn('route_id', 'integer', ['null' => true, 'signed' => false])
                ->addForeignKey('route_id', $routesTable, ['id'])
                ->update();
        }

//        $users->changeColumn('email', 'string', array('limit' => 255))
//        phinx migrate -e development -t 20160626184519
//        phinx rollback -e development    - rollback prev
//        phinx rollback -e development -t 20120103083322 - concrete
    }
}
