<?php

namespace App\Core\Controllers;

class Clients extends AdminController
{
    public function index()
    {
        $data = [
            'title' => 'Clients',
            'clients' => [
                [
                    'id' => 1,
                    'name' => 'Acme Corporation',
                    'primary_contact' => 'John Doe',
                    'phone' => '+1 555-1234',
                    'labels' => ['VIP', 'Long-term'],
                    'projects' => 5,
                ],
                [
                    'id' => 2,
                    'name' => 'Globex Ltd',
                    'primary_contact' => 'Jane Smith',
                    'phone' => '+1 555-5678',
                    'labels' => ['New'],
                    'projects' => 2,
                ],
                [
                    'id' => 3,
                    'name' => 'Initech',
                    'primary_contact' => 'Peter Gibbons',
                    'phone' => '+1 555-9012',
                    'labels' => ['At Risk'],
                    'projects' => 1,
                ],
            ]
        ];

        return $this->coreView('Layouts/Clients/index', $data);
    }

     public function add()
    {
        $data['title'] = "Add Client";
        return $this->coreView('Layouts/Clients/add', $data);
    }

    public function edit($id)
    {
        // Dummy client
        $data = [
            'title' => "Edit Client",
            'client' => [
                'id' => $id,
                'name' => 'Acme Corporation',
                'primary_contact' => 'John Doe',
                'phone' => '+1 555-1234',
                'labels' => 'VIP',
            ]
        ];
        return $this->coreView('Layouts/Clients/edit', $data);
    }

    public function view($id)
    {
        $data = [
            'title' => "View Client",
            'client' => [
                'id' => $id,
                'name' => 'Acme Corporation',
                'primary_contact' => 'John Doe',
                'phone' => '+1 555-1234',
                'labels' => 'VIP',
                'projects' => 5,
            ]
        ];
        return $this->coreView('Layouts/Clients/view', $data);
    }
}
