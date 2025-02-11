<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRafflesPrizes extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],

            'raffle_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],

            'prize_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],

        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('raffle_id');
        $this->forge->addKey('prize_id');


        $this->forge->addForeignKey('raffle_id', 'raffles', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('prize_id', 'prizes', 'id', 'CASCADE', 'CASCADE');


        $this->forge->createTable('raffles_prizes');
    }

    public function down()
    {
        $this->forge->dropTable('raffles_prizes');
    }
}
