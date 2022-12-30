<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Owner extends Migration
{
    public function up()
    {
        // Drop table 'owner' if it exists
        $this->forge->dropTable('owner', true);

        // Table structure for table 'owner'
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => '11',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'created_at' => [
                'type'       => 'DATE'
            ],
            'updated_at' => [
                'type'       => 'DATE'
            ],
            'deleted_at' => [
                'type'       => 'DATE',
                'null'       => TRUE
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('owner');
    }

    public function down()
    {
        $this->forge->dropTable('owner', true);
    }
}
