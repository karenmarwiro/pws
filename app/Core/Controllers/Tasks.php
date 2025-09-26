<?php

namespace App\Core\Controllers;

use App\Core\Controllers\AdminController;

class Tasks extends AdminController
{
    public function index()
    {
        

        // Load the Core modules view using BaseController helper
        return $this->coreView('Layouts/Tasks/index');
    }
}
