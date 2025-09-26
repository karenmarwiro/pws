<?php

namespace App\Core\Config;

use CodeIgniter\Config\BaseService;
use App\Core\Services\RoleAccess;

class Services extends BaseService
{
    public static function roleAccess(bool $getShared = true): RoleAccess
    {
        if ($getShared) {
            return static::getSharedInstance('roleAccess');
        }
        return new RoleAccess();
    }
}