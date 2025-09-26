<?php

namespace App\Core\Controllers;

use App\Core\Controllers\AdminController;

class Team extends AdminController
{
    public function index()
    {
        $data = [
            'title' => 'Users',
            'users' => [
                ['id' => 1, 'name' => 'Alice', 'email' => 'alice@example.com'],
                ['id' => 2, 'name' => 'Bob', 'email' => 'bob@example.com'],
                ['id' => 3, 'name' => 'Charlie', 'email' => 'charlie@example.com'],
            ],
        ];

        return $this->coreView('Layouts/Team/index', $data);
    }

     public function add()
    {
        return $this->coreView('Users/add', [
            'title' => 'Add User',
        ]);
    }

    public function edit($id = null)
    {
        // Find the user by ID
        $user = null;
        foreach ($this->users as $u) {
            if ($u['id'] == $id) {
                $user = $u;
                break;
            }
        }

        if (!$user) {
            return redirect()->to('/users')->with('error', 'User not found.');
        }

        return $this->coreView('Users/edit', [
            'title' => 'Edit User',
            'user' => $user,
        ]);
    }
}
