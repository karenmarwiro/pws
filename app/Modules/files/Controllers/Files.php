<?php

namespace App\Modules\Files\Controllers;

use App\Core\Controllers\AdminController;

class Files extends AdminController
{
    public function index()
    {
        $data = [
            'title' => 'Files',
        ];

        // Use moduleView helper for HMVC compatibility
        return $this->moduleView('files', 'index', $data);
    }
}
