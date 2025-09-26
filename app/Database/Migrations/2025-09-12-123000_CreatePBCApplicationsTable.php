<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePBCApplicationsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'reference_no' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false,
            ],
            'applicant_name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'business_name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['pending', 'processing', 'approved', 'rejected'],
                'default' => 'pending',
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
        $this->forge->addKey('reference_no');
        $this->forge->addKey('status');
        $this->forge->createTable('pbc_applications');
    }

    public function down()
    {
        $this->forge->dropTable('pbc_applications');
    }
}
