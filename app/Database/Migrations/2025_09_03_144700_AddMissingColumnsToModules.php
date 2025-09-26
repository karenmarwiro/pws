<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddMissingColumnsToModules extends Migration
{
    public function up()
    {
        $fields = [
            'namespace' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'version'
            ],
            'path' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'namespace',
                'comment' => 'Path to the module directory relative to ROOTPATH'
            ],
            'author' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'after' => 'icon'
            ],
            'order' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
                'after' => 'author',
                'comment' => 'Display order'
            ],
            'settings' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'order',
                'comment' => 'JSON encoded module settings'
            ]
        ];

        $this->forge->addColumn('modules', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('modules', ['namespace', 'path', 'author', 'order', 'settings']);
    }
}
