<?php

namespace App\Core\Models;

use CodeIgniter\Model;

class AuthIdentitiesModel extends Model
{
    protected $table      = 'auth_identities';
    protected $primaryKey = 'id';

    // 👇 Always return objects
    protected $returnType = 'object';

    protected $allowedFields = [
        'user_id',
        'type',
        'name',
        'secret',
        'secret2',
        'expires',
        'extra',
        'force_reset',
        'last_used_at',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Find identity by user ID and type (e.g., email, username)
     */
    public function getByUserAndType(int $userId, string $type)
    {
        return $this->where('user_id', $userId)
                    ->where('type', $type)
                    ->first();
    }

    /**
     * Find identity by email (common use case)
     */
    public function getByEmail(string $email)
    {
        return $this->where('secret', $email)
                    ->where('type', 'email_password') // adjust if your type is different
                    ->first();
    }
}
