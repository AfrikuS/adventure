<?php

use Phinx\Migration\AbstractMigration;

class AlterTableShopPricesMigration extends AbstractMigration
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
        $table = $this->table('travel_materials_prices');
        $table->addColumn('shop_id', 'integer', ['signed' => false, 'null' => false, 'after' => 'ship_id'])
            ->addForeignKey(['shop_id'], 'market_temp_shops', ['id'])
            ->addIndex(['shop_id', 'material_id'], ['unique' => true]);

//            ->dropForeignKey('ship_id')
//            ->removeIndex('unique_ship_material')
//            ->removeColumn('ship_id')
//            ->save();


    }
}
