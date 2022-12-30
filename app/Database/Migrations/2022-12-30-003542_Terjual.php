<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Terjual extends Migration
{
    public function up()
    {
        // Drop table 'terjual' if it exists
        $this->forge->dropTable('terjual', true);

        // Table structure for table 'terjual'
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => '11',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_barang' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'constraint' => 11,
            ],
            'jumlah' => [
                'type'       => 'TINYINT',
                'constraint' => 10,
            ],
            'created_at' => [
                'type'       => 'DATETIME'
            ],
            'updated_at' => [
                'type'       => 'DATETIME'
            ],
            'deleted_at' => [
                'type'       => 'DATETIME',
                'null'       => TRUE
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('terjual');
    }

    public function down()
    {
        $this->forge->dropTable('terjual', true);
    }
}
