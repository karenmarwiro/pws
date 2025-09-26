<?php

namespace App\Core\Controllers;

use App\Controllers\BaseController;
use App\Core\Models\UsersModel;
use App\Core\Models\AuthIdentitiesModel;

class Users extends AdminController
{
    protected $usersModel;
    protected $authIdentitiesModel;
    protected $roleAccess;

    public function __construct()
    {
        $this->usersModel          = new UsersModel();
        $this->authIdentitiesModel = new AuthIdentitiesModel();
        $this->roleAccess          = service('roleAccess');
    }



    /**
     * List all users
     */
   public function index()
{
    $users = $this->usersModel->findAll();
    $processedUsers = [];

    foreach ($users as $user) {
        $roles = $this->roleAccess->getUserRoles($user->id); // use object syntax
        $user->roles = $roles; // attach roles
        $processedUsers[] = $user;
    }

    return $this->coreView('users/index', [
        'users' => $processedUsers,
    ]);
}


    /**
     * View a single user
     */
    public function view($id)
    {
        $user  = $this->usersModel->find($id);
        $roles = $this->roleAccess->getUserRoles($id);

        if (!$user) {
            return redirect()->to(site_url('users'))->with('error', 'User not found.');
        }

        return $this->coreView('users/view', [
            'title' => 'View User',
            'user'  => $user,
            'roles' => $roles,
        ]);
    }

    /**
     * Show add user form
     */
    public function showAddForm()
    {
        $rawGroups = model('GroupModel')->findAll() ?? [];

        $groups = array_map(function ($g) {
            if (is_object($g)) {
                $name = $g->name ?? $g->group ?? null;
            } else {
                $name = $g['name'] ?? $g['group'] ?? null;
            }
            return ['name' => $name];
        }, $rawGroups);

        $groups = array_values(array_filter($groups, fn($x) => !empty($x['name'])));

        return $this->coreView('users/add', [
            'title'  => 'Add User',
            'groups' => $groups,
        ]);
    }

    /**
     * Store new user
     */
    public function storeUser()
    {
        $username = $this->request->getPost('username');
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $role     = $this->request->getPost('role');

        if (!$username || !$email || !$password || !$role) {
            return redirect()->back()->withInput()->with('error', 'All fields are required.');
        }

        // Step 1: Insert into users table
        $userId = $this->usersModel->insert([
            'username' => $username,
            'status'   => 'active',
            'active'   => 1,
        ]);

        if (!$userId) {
            return redirect()->back()->withInput()->with('error', 'Failed to create user.');
        }

        // Step 2: Insert into auth_identities
        $this->authIdentitiesModel->insert([
            'user_id' => $userId,
            'type'    => 'email_password',
            'name'    => $email,
            'secret'  => password_hash($password, PASSWORD_DEFAULT),
        ]);

        // Step 3: Assign role
        $this->roleAccess->assignUserRole($userId, $role);

        return redirect()->to(site_url('rbac/users'))->with('success', 'User created successfully.');
    }

    /**
     * Show edit user form
     */
/**
 * Show the Edit User form
 */
public function edit($id)
{
    $user = $this->usersModel->find($id); // stdClass from users table
    if (!$user) {
        return redirect()->to(site_url('rbac/users'))->with('error', 'User not found.');
    }

    // Fetch email from auth_identities
    $identity = $this->authIdentitiesModel
                     ->where('user_id', $id)
                     ->where('type', 'email_password')
                     ->first();

    $user->email = $identity->name ?? '';

    // Fetch current roles
    $user->roles = $this->roleAccess->getUserRoles($id);

    // Fetch all available roles for the select dropdown
    $allRoles = $this->roleAccess->getAllRoles();

    return $this->coreView('users/edit', [
        'title'    => 'Edit User',
        'user'     => $user,
        'allRoles' => $allRoles,
    ]);
}

/**
 * Update user
 */
public function update($id)
{
    $email    = $this->request->getPost('email');
    $password = $this->request->getPost('password');
    $role     = $this->request->getPost('role'); // selected role

    if (!$email) {
        return redirect()->back()->withInput()->with('error', 'Email is required.');
    }

    // 1️⃣ Update email in auth_identities
    $this->authIdentitiesModel
        ->where('user_id', $id)
        ->where('type', 'email_password')
        ->set(['name' => $email])
        ->update();

    // 2️⃣ Update password if provided
    if (!empty($password)) {
        $this->authIdentitiesModel
            ->where('user_id', $id)
            ->where('type', 'email_password')
            ->set(['secret' => password_hash($password, PASSWORD_DEFAULT)])
            ->update();
    }

    // 3️⃣ Update role if provided
    if ($role) {
        $this->roleAccess->assignUserRole($id, $role); // assigns or updates role
    }

    return redirect()->to(site_url('rbac/users'))->with('success', 'User updated successfully.');
}

    /**
     * Delete user
     */
    public function delete($id)
    {
        $this->usersModel->delete($id);
        $this->authIdentitiesModel->where('user_id', $id)->delete();

        return redirect()->to(site_url('rbac/users'))->with('success', 'User deleted.');
    }

    /**
     * Assign role to user
     */
   public function assignRole($id)
{
    $user = $this->usersModel->find($id);

    if (!$user) {
        return redirect()->to(site_url('rbac/users'))->with('error', 'User not found.');
    }

    // Fetch roles and attach to user object
    $userRoles = $this->roleAccess->getUserRoles($id); // returns array
    $user->roles = $userRoles;

    // Handle POST submission
    if ($this->request->getMethod() === 'post') {
        $role = $this->request->getPost('role');

        if (!$role) {
            return redirect()->back()->with('error', 'Please select a role.');
        }

        // Assign role
        $ok = $this->roleAccess->assignUserRole($id, $role);

        return redirect()->to(site_url('users/view/'.$id))
                         ->with($ok ? 'success' : 'error', $ok ? 'Role assigned successfully.' : 'Failed to assign role.');
    }

    $data = [
        'title'    => 'Assign Role to User',
        'user'     => $user,
        'allRoles' => $this->roleAccess->getAllRoles(),
    ];

    return $this->coreView('users/assign', $data);
}

    /**
     * Remove role from user
     */
    public function removeRole($id, $role)
    {
        $this->roleAccess->removeRole($id, $role);
        return redirect()->to(site_url('users/view/' . $id))
                         ->with('success', 'Role removed.');
    }
}
