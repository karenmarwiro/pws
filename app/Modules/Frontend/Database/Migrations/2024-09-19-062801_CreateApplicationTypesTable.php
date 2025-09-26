<?php

namespace App\Modules\Frontend\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateApplicationTypesTable extends Migration
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
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'requirements' => [
                'type' => 'TEXT',
                'null' => true,
                'comment' => 'JSON string of requirements for this application type',
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
        $this->forge->createTable('application_types');

        // Insert default application types
        $data = [
            [
                'name' => 'Private Business Corporation (PBC)',
                'description' => 'Registration for Private Business Corporations',
                'requirements' => json_encode([
                    'Minimum 1 director',
                    'Minimum 1 shareholder',
                    'Registered office address in Zimbabwe',
                ]),
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Private Limited Company (PLC)',
                'description' => 'Registration for Private Limited Companies',
                'requirements' => json_encode([
                    'Minimum 2 directors',
                    'Minimum 1 shareholder',
                    'Maximum 50 shareholders',
                    'Registered office address in Zimbabwe',
                ]),
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('application_types')->insertBatch($data);
    }

    public function down()
    {
        $this->forge->dropTable('application_types');
    }
}
