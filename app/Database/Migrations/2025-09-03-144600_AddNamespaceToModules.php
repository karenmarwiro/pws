<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddNamespaceToModules extends Migration
{
    public function up()
    {
        $fields = [
            'namespace' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'version'
            ]
        ];

        $this->forge->addColumn('modules', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('modules', 'namespace');
    }
}
