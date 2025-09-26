<?php

namespace App\Core\Controllers;

use App\Core\Models\AuthGroupsModel;
use App\Core\Models\AuthGroupsUsersModel;

class RBAC extends AdminController
{
    protected $rbac;
    protected $authGroupsModel;
    protected $authGroupsUsersModel;

    public function initController(
        \CodeIgniter\HTTP\RequestInterface $request,
        \CodeIgniter\HTTP\ResponseInterface $response,
        \Psr\Log\LoggerInterface $logger
    ) {
        parent::initController($request, $response, $logger);

        $this->rbac = service('rbac');
        $this->authGroupsModel = new AuthGroupsModel();
         $this->authGroupsUsersModel = new AuthGroupsUsersModel();
    }

    /**
     * Require a permission to access an action
     */
    protected function requirePermission(string $permission)
    {
        $auth = service('auth');
        $user = $auth->user();

        if (!$user) {
            return redirect()->to(route_to('login'))
                             ->with('error', 'Please login first');
        }

        if (in_array('admin', $user->getGroups()) ||
            in_array('superuser', $user->getGroups())) {
            return;
        }

        if (!$user->can($permission)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException(
                'You do not have permission to access this page'
            );
        }
    }

    /* ===== ROLES ===== */

    public function index()
    {
       

        $roles = $this->rbac->getAllRoles();
        $processedRoles = [];

        foreach ($roles as $role) {
            $roleName = $role['group'] ?? '';
            if (!$roleName) {
                continue;
            }

            $processedRoles[] = [
                'id'          => $role['id'] ?? null,
                'group'       => $roleName,
                'description' => $role['description'] ?? '',
                'users_count' => count($this->rbac->getUsersByRole($roleName)),
            ];
        }

        return $this->coreView('rbac/index', [
            'title'       => 'Role-Based Access Control',
            'roles'       => $processedRoles,
            'permissions' => $this->rbac->getAllPermissions(),
        ]);
    }

    public function createRole()
    {
        return $this->coreView('rbac/roles_add', [
            'title' => 'Add Role',
            'validation' => \Config\Services::validation(),
        ]);
    }

    public function addRole()
    {
        $data = [
            'group'       => $this->request->getPost('group'),
            'description' => $this->request->getPost('description'),
        ];

        $this->authGroupsModel->insert($data);

        return redirect()->to('rbac/roles')
                         ->with('success', 'Role added successfully.');
    }

    public function editRole($id)
{
    $role = $this->rbac->getRoleById((int) $id);
    if (!$role) {
        return redirect()->to('rbac')->with('error', 'Role not found.');
    }

    // Only show the form
    return $this->coreView('rbac/roles_edit', [
        'title' => 'Edit Role',
        'role'  => $role,
    ]);
}

public function updateRole($id)
{
    $role = $this->rbac->getRoleById((int) $id);
    if (!$role) {
        return redirect()->to('rbac')->with('error', 'Role not found.');
    }

    $updateData = [
        'group'       => $this->request->getPost('group'),
        'description' => $this->request->getPost('description'),
    ];
    $this->authGroupsModel->update($id, $updateData);

    return redirect()->to('rbac/roles')
                     ->with('success', 'Role updated.');
}


    public function deleteRole($id)
    {
        $this->authGroupsModel->delete($id);
        return redirect()->to('rbac/roles')
                         ->with('success', 'Role deleted.');
    }


   /** Show assign role form */
public function showAssignRoleForm($userId)
{
    

    $user = $this->rbac->getUser((int) $userId);
    if (!$user) {
        return redirect()->to('rbac')->with('error', 'User not found.');
    }

    return $this->coreView('rbac/role_assign_user', [
        'title'   => 'Assign Role to User',
        'user'    => $user,
        'roles'   => $this->rbac->getAllRoles(),
        'current' => $this->rbac->getUserRoles((int) $userId),
    ]);
}

/** Handle role assignment (POST) */
public function assignRoleToUser($userId)
{
   

    $roleName = $this->request->getPost('role');
    if (!$roleName) {
        return redirect()->back()->with('error', 'Please select a role.');
    }

    // 🔑 Remove old roles (if you allow only one per user)
    $this->authGroupsUsersModel->where('user_id', $userId)->delete();

    // 🔑 Insert new role
    $ok = $this->authGroupsUsersModel->insert([
        'user_id' => $userId,
        'group'   => $roleName,
    ]);

    return redirect()->to('rbac')
        ->with($ok ? 'success' : 'error', $ok ? 'Role assigned.' : 'Failed to assign role.');
}



    public function removeRoleFromUser($userId)
    {
        $this->requirePermission('rbac.assign');

        if ($this->request->getMethod() === 'post') {
            $roleName = $this->request->getPost('role');
            $ok = $this->rbac->removeRoleFromUser((int) $userId, $roleName);

            return redirect()->to('rbac')
                ->with($ok ? 'success' : 'error', $ok ? 'Role removed.' : 'Failed to remove role.');
        }

        return redirect()->to('rbac');
    }

    /* ===== PERMISSIONS ===== */

    public function permissions()
    {
        $this->requirePermission('rbac.view');

        $permissions = $this->rbac->getAllPermissions();
        $roles = $this->authGroupsModel->findAll();

        $groupedPerms = [];
        foreach ($permissions as $perm) {
            $group = $perm['group'] ?? 'general';
            $groupedPerms[$group][] = $perm;
        }

        return $this->coreView('rbac/permissions_index', [
            'title'        => 'Manage Permissions',
            'permissions'  => $permissions,
            'groupedPerms' => $groupedPerms,
            'roles'        => $roles,
            'current'      => []
        ]);
    }

   

    public function editPermission($id)
    {
        $this->requirePermission('rbac.manage');

        $perm = $this->rbac->getPermissionById((int) $id);
        if (!$perm) {
            return redirect()->to('rbac/permissions')->with('error', 'Permission not found.');
        }

        if ($this->request->getMethod() === 'post') {
            $updateData = [
                'permission'  => $this->request->getPost('permission'),
                'description' => $this->request->getPost('description'),
            ];
            $ok = $this->rbac->updatePermission((int) $id, $updateData);

            return redirect()->to('rbac/permissions')
                ->with($ok ? 'success' : 'error', $ok ? 'Permission updated.' : 'Failed to update permission.');
        }

        return $this->coreView('rbac/permissions_edit', [
            'title' => 'Edit Permission',
            'perm'  => $perm,
        ]);
    }

    public function deletePermission($id)
    {
        $this->requirePermission('rbac.manage');

        if ($this->request->getMethod() === 'post') {
            $ok = $this->rbac->deletePermission((int) $id);

            return redirect()->to('rbac/permissions')
                ->with($ok ? 'success' : 'error', $ok ? 'Permission deleted.' : 'Failed to delete permission.');
        }

        return redirect()->to('rbac/permissions');
    }

    /* ===== ROLE ↔ PERMISSIONS ===== */

    public function rolePermissions($roleId)
    {
        $this->requirePermission('rbac.manage');

        $role = $this->rbac->getRoleById((int) $roleId);
        if (!$role) {
            return redirect()->to('rbac')->with('error', 'Role not found.');
        }

        $allPerms = $this->rbac->getAllPermissions();
        $hasPerms = $this->rbac->getRolePermissionsByName($role['group']);
        $owned    = array_column($hasPerms, 'permission');

        $groupedPerms = [];
        foreach ($allPerms as $perm) {
            $group = $perm['group'] ?? 'general';
            $groupedPerms[$group][] = $perm;
        }

        return $this->coreView('rbac/role_permissions', [
            'title'        => 'Role Permissions: ' . $role['group'],
            'role'         => $role,
            'allPerms'     => $allPerms,
            'ownedPerms'   => $owned,
            'groupedPerms' => $groupedPerms,
        ]);
    }

    public function saveRolePermissions($roleId)
    {
        $this->requirePermission('rbac.manage');

        $role = $this->rbac->getRoleById((int) $roleId);
        if (!$role) {
            return redirect()->to('rbac')->with('error', 'Role not found.');
        }

        $this->rbac->resetRolePermissions($role['group']);

        $perms = $this->request->getPost('permissions') ?? [];
        foreach ($perms as $slug) {
            $this->rbac->assignPermissionToRole($role['group'], $slug);
        }

        return redirect()->to('rbac')
            ->with('success', 'Permissions updated for role: ' . $role['group']);
    }
}
