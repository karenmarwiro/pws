<?php

namespace App\Core\Services;

use App\Core\Models\AuthGroupsUsersModel;
use App\Core\Models\AuthGroupsPermissionsModel;

class RBAC
{
    protected $groupsUsersModel;
    protected $groupsPermissionsModel;

    public function __construct()
    {
        $this->groupsUsersModel = new AuthGroupsUsersModel();
        $this->groupsPermissionsModel = new AuthGroupsPermissionsModel();
    }

    public function getUserRoles(int $userId): array
    {
        return $this->groupsUsersModel
            ->where('user_id', $userId)
            ->findAll() ? array_column(
                $this->groupsUsersModel->where('user_id', $userId)->findAll(),
                'group'
            ) : [];
    }

    public function roleHasPermission(string $role, string $permission): bool
    {
        return (bool) $this->groupsPermissionsModel
            ->where('group', $role)
            ->where('permission', $permission)
            ->first();
    }

    public function userHasPermission(int $userId, string $permission): bool
    {
        $roles = $this->getUserRoles($userId);

        log_message('debug', "Checking permission: {$permission} for user {$userId} with roles " . json_encode($roles));

        if (in_array('admin', array_map('strtolower', $roles))) {
            return true;
        }

        foreach ($roles as $role) {
            if ($this->roleHasPermission($role, $permission)) {
                return true;
            }
        }

        return false;
    }

    public function getAllRoles(): array
    {
        try {
            $model = new \App\Core\Models\AuthGroupsModel();
            return $model->findAll() ?? [];
            
        } catch (\Exception $e) {
            log_message('error', 'Error in getAllRoles: ' . $e->getMessage());
            return [];
        }
    }

    public function getUsersByRole(string $role): array
    {
        try {
            $model = new \App\Core\Models\AuthGroupsUsersModel();
            return $model->where('group', $role)->findAll() ?: [];
        } catch (\Exception $e) {
            log_message('error', 'Error in getUsersByRole: ' . $e->getMessage());
            return [];
        }
    }

    public function getAllPermissions(): array
    {
        $model = new \App\Core\Models\AuthPermissionsModel();
        return $model->findAll() ?? [];
    }

    public function getRoleById(int $id): ?array
    {
        $model = new \App\Core\Models\AuthGroupsModel();
        return $model->find($id);
    }

    public function createRole(array $data): bool
    {
        log_message('debug', 'RBAC::createRole called with data: ' . print_r($data, true));
        
        try {
            // Ensure we have all required fields
            $roleData = [
                'group' => $data['group'] ?? '',
                'description' => $data['description'] ?? ''
            ];
            
            log_message('debug', 'Processing role creation with data: ' . print_r($roleData, true));
            
            // Check if role already exists
            $existingRole = $this->checkRoleExists($roleData['group']);
            if ($existingRole) {
                log_message('debug', 'Role already exists with name: ' . $roleData['group']);
                return false;
            }
            
            // Use the model to insert the data
            $model = new \App\Core\Models\AuthGroupsModel();
            
            log_message('debug', 'Calling model insert with data: ' . print_r($roleData, true));
            
            $result = $model->insert($roleData);
            
            if ($result === false) {
                $errors = $model->errors();
                log_message('error', 'Failed to create role. Model errors: ' . print_r($errors, true));
                return false;
            }
            
            log_message('info', 'Successfully created role: ' . $roleData['group'] . ' with ID: ' . $result);
            return true;
            
        } catch (\Exception $e) {
            log_message('error', 'Exception in createRole: ' . $e->getMessage());
            log_message('error', 'Exception trace: ' . $e->getTraceAsString());
            return false;
        }
    }
    
    /**
     * Check if a role with the given name already exists
     */
    protected function checkRoleExists(string $roleName): bool
    {
        try {
            $model = new \App\Core\Models\AuthGroupsModel();
            $count = $model->where('group', $roleName)->countAllResults();
            return $count > 0;
        } catch (\Exception $e) {
            log_message('error', 'Error checking if role exists: ' . $e->getMessage());
            return false;
        }
    }

    public function updateRole(int $id, array $data): bool
    {
        $model = new \App\Core\Models\AuthGroupsModel();
        return $model->update($id, $data);
    }

    public function deleteRole(int $id): bool
    {
        $model = new \App\Core\Models\AuthGroupsModel();
        return $model->delete($id);
    }

    public function getPermissionById(int $id): ?array
    {
        $model = new \App\Core\Models\AuthPermissionsModel();
        return $model->find($id);
    }

    public function createPermission(array $data): bool
    {
        $model = new \App\Core\Models\AuthPermissionsModel();
        return $model->insert($data) !== false;
    }

    public function updatePermission(int $id, array $data): bool
    {
        log_message('debug', 'RBAC::updatePermission - Starting update for ID: ' . $id . ' with data: ' . print_r($data, true));
        
        try {
            $model = new \App\Core\Models\AuthPermissionsModel();
            
            // Check if the permission exists
            $permission = $model->find($id);
            if (!$permission) {
                log_message('error', "RBAC::updatePermission - Permission with ID {$id} not found");
                return false;
            }
            
            log_message('debug', 'RBAC::updatePermission - Current permission data: ' . print_r($permission, true));
            
            // Update the permission
            $result = $model->update($id, $data);
            
            if ($result === false) {
                $error = $model->errors() ?? 'Unknown error';
                log_message('error', "RBAC::updatePermission - Update failed for ID {$id}. Errors: " . print_r($error, true));
            } else {
                log_message('debug', "RBAC::updatePermission - Successfully updated permission ID: {$id}");
            }
            
            return $result !== false;
            
        } catch (\Exception $e) {
            log_message('error', 'RBAC::updatePermission - Exception: ' . $e->getMessage());
            log_message('error', 'RBAC::updatePermission - Stack trace: ' . $e->getTraceAsString());
            return false;
        }
    }

    public function deletePermission(int $id): bool
    {
        $model = new \App\Core\Models\AuthPermissionsModel();
        return $model->delete($id);
    }

    public function getRolePermissionsByName(string $role): array
    {
        return $this->groupsPermissionsModel
            ->where('group', $role)
            ->findAll() ?: [];
    }

    public function resetRolePermissions(string $role): bool
    {
        return $this->groupsPermissionsModel
            ->where('group', $role)
            ->delete() !== false;
    }

    public function assignPermissionToRole(string $role, string $permission): bool
    {
        return $this->groupsPermissionsModel->insert([
            'group' => $role,
            'permission' => $permission
        ]);
    }

    public function getUser(int $userId): ?object
    {
        $users = auth()->getProvider();
        return $users->findById($userId);
    }

    public function assignRoleToUser(int $userId, string $role): bool
    {
        return $this->groupsUsersModel->insert([
            'user_id' => $userId,
            'group' => $role
        ]);
    }

    public function removeRoleFromUser(int $userId, string $role): bool
    {
        return $this->groupsUsersModel
            ->where('user_id', $userId)
            ->where('group', $role)
            ->delete() !== false;
    }
}