<?php

namespace App\Modules\Notifications\Controllers;

use App\Core\Controllers\AdminController;

class Notifications extends AdminController
{
    public function index()
    {
        $data = [
            'title' => 'Notifications',
            'items' => [
                ['user' => 'John Doe', 'comment' => 'Great post!', 'status' => 'Approved'],
                ['user' => 'Jane Smith', 'comment' => 'Needs improvement', 'status' => 'Pending'],
                ['user' => 'Admin', 'comment' => 'System comment', 'status' => 'Approved'],
            ],
        ];

        // Use moduleView helper for HMVC compatibility
        return $this->moduleView('notifications','index', $data);
    }
}
