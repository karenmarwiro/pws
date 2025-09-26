<?php

namespace App\Modules\Pbc\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePbc extends Migration
{
    public function up()
    {
        if ($this->db->tableExists('pbc')) {
            return;
        }

        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'slug' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('pbc');
    }

    public function down()
    {
        if ($this->db->tableExists('pbc')) {
            $this->forge->dropTable('pbc');
        }
    }
}
