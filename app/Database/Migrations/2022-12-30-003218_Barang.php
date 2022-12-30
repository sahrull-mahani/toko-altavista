<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Barang extends Migration
{
    public function up()
    {
        // Drop table 'barang' if it exists
        $this->forge->dropTable('barang', true);

        // Table structure for table 'barang'
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => '11',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'type' => [
                'type'       => 'ENUM',
                'constraint' => ['umum', 'kue'],
            ],
            'id_owner' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'null'       => true,
                'constraint' => 11,
            ],
            'kode_barang' => [
                'type'       => 'CHAR',
                'constraint' => 50,
            ],
            'nama_barang' => [
                'type'       => 'CHAR',
                'constraint' => 150,
            ],
            'harga' => [
                'type'       => 'INT',
                'constraint' => 20,
            ],
            'stok' => [
                'type'       => 'TINYINT',
                'constraint' => 10,
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
        $this->forge->createTable('barang');
    }

    public function down()
    {
        $this->forge->dropTable('barang', true);
    }
}
