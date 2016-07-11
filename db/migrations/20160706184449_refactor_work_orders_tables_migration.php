<?php

use Phinx\Migration\AbstractMigration;

class RefactorWorkOrdersTablesMigration extends AbstractMigration
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
//        DB::beginTransaction();
//        try {

            // ???? too many refs on this table
            // RENAEM TABLE work_team_workers` -> work_workers
            if ($this->hasTable('work_team_workers')) {
                $workers = $this->table('work_team_workers');
                $workers->rename('work_workers');
            }

//        DELETE
//            work_teamorders, work_teamorder_skills, work_teamorder_materials
            if ($this->hasTable('work_teamorder_materials')) {
                $this->dropTable('work_teamorder_materials');
            }
            if ($this->hasTable('work_teamorder_skills')) {
                $this->dropTable('work_teamorder_skills');
            }
            if ($this->hasTable('work_teamorders')) {
                $this->dropTable('work_teamorders');
            }

            // ADD_COLUMNS
            if ($this->hasTable('work_orders')) {
                $workOrders = $this->table('work_orders');

                // work_order -> order_type, status, acceptor_id
                if (!$workOrders->hasColumn('order_type')) {
                    $workOrders
                        ->addColumn('order_type', 'string', ['null' => false, 'length' => 255])
                        ->update();
                }
                // work_order ->     FOREIGN KEY (acceptor_user_id) REFERENCES users(id)
                if (!$workOrders->hasColumn('acceptor_worker_id')) {
                    $workOrders
                        ->addColumn('acceptor_worker_id',   'integer', ['null' => false, 'signed' => false])
                        ->addForeignKey('acceptor_worker_id', 'work_workers', 'id')
                        ->create();
                }
            }

            // ADD TABLE work_order_skills
            if (!$this->hasTable('work_order_skills')) {
                $orderSkills = $this->table('work_order_skills');

                $orderSkills
                    ->addColumn('order_id',   'integer', ['null' => false, 'signed' => false])
                    ->addColumn('code', 'string', ['null' => false, 'length' => 255])
                    ->addColumn('need_times',   'integer', ['null' => false, 'signed' => false])
                    ->addColumn('stock_times',  'integer', ['null' => false, 'signed' => false])
                    ->update();

                $orderSkills
                    ->addForeignKey('order_id', 'work_orders', 'id')
                    ->addIndex([`code`,`order_id`], ['unique' => true, 'name' => 'unique_order_skill'])
                    ->create();

                $orderSkills
                    ->changeColumn('id', 'integer', ['null' => false, 'signed' => false])
                    ->update();
            }



//        }
//        catch (\Exception $e) {
//            \DB::rollBack();
//            throw $e;
//        }
//        \DB::commit();


    }

    public function down()
    {
    }
}
