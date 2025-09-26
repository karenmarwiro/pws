<?php

namespace App\Core\Services;

use CodeIgniter\Shield\Models\UserModel;
use CodeIgniter\Shield\Models\GroupModel;  // <-- add this
use CodeIgniter\Shield\Entities\User;

class RoleAccess
{
    protected $auth;

    public function __construct()
    {
        $this->auth = service('authentication');
    }

    public function user(): ?User
    {
        return $this->auth->user();
    }

    public function hasRole(string $role, ?int $userId = null): bool
    {
        $user = $this->getUser($userId);
        return $user ? $user->inGroup($role) : false;
    }

    public function hasPermission(string $permission, ?int $userId = null): bool
    {
        $user = $this->getUser($userId);
        return $user ? $user->can($permission) : false;
    }

    public function assignUserRole(int $userId, string $role): bool
    {
        $model = new \App\Core\Models\AuthGroupsUsersModel();
        
        // Check if already assigned
        $existing = $model->where('user_id', $userId)->first();
        
        if ($existing) {
            // Update existing role
            return $model->update($existing['id'], ['group' => $role]);
        }

        // Insert new role
        return (bool) $model->insert([
            'user_id' => $userId,
            'group' => $role,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function removeRole(int $userId, string $role): bool
    {
        $user = $this->getUser($userId);
        return $user ? $user->removeGroup($role) : false;
    }

    public function getUserRoles(int $userId): array
    {
        $user = $this->getUser($userId);
        return $user ? $user->getGroups() : [];
    }

    public function getAllRoles(): array
    {
        $model = new \App\Core\Models\AuthGroupsModel();
        $roles = $model->findAll();
        
        // Extract just the group names
        return array_map(fn($role) => $role['group'] ?? $role['name'] ?? '', $roles);
    }

    protected function getUser(?int $userId = null): ?User
    {
        if ($userId === null) {
            return $this->auth->user();
        }
        return (new UserModel())->find($userId);
    }
}