<?php

use Phinx\Migration\AbstractMigration;

class CreateNpcDealTablesMigration extends AbstractMigration
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
        if (!$this->hasTable('npc_deals')) {
            $users = $this->table('users');

            $npcOffers = $this->table('npc_deals');

            $npcOffers
                ->addColumn('hero_id', 'integer', ['null' => false, 'signed' => false])
                ->addColumn('npc_char', 'string', ['null' => false, 'signed' => false])
                ->addColumn('task', 'string', ['null' => false, 'signed' => false])
                ->addColumn('reward', 'string', ['null' => false, 'signed' => false])
                ->addColumn('offer_status', 'string', ['null' => false, 'length' => 255])
                ->addColumn('offer_ending', 'datetime', ['null' => true])
                ->addColumn('deal_status', 'string', ['null' => false, 'length' => 255])
                ->addColumn('deal_ending', 'datetime', ['null' => true])

                ->addForeignKey('hero_id', $users, 'id')
                ->create();
        }
    }

    public function down()
    {
        if ($this->hasTable('npc_deals')) {
            $this->table('npc_deals')->drop();
        }
    }
}

