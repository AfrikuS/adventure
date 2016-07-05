<?php

use Phinx\Migration\AbstractMigration;

class AddGarageVehicleMigration extends AbstractMigration
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
        if (!$this->hasTable('drive_drivers')) {
            $users = $this->table('users');

            $drivers = $this->table('drive_drivers');
            $drivers->create();
            $drivers
                ->changeColumn('id', 'integer', ['null' => false, 'signed' => false])
                ->addForeignKey('id', $users, 'id')
                ->create();

            $vehicles = $this->table('drive_vehicles');
            $vehicles
                ->addColumn('driver_id',   'integer', ['null' => false, 'signed' => false])
                ->addColumn('acceleration',   'integer', ['null' => false, 'signed' => false])
                ->addColumn('stability',   'integer', ['null' => false, 'signed' => false])
                ->addColumn('mobility', 'integer', ['null' => false, 'signed' => false])
                ->addForeignKey('driver_id', $drivers, 'id')
                ->create();

            $vehicles
                ->changeColumn('id', 'integer', ['null' => false, 'signed' => false])
                ->update();
        }
    }

    public function down()
    {
        if ($this->hasTable('drive_drivers')) {
            $this->table('drive_drivers')->drop();
            $this->table('drive_vehicles')->drop();
        }
    }
}
