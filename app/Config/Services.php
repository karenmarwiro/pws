<?php

namespace Config;

use CodeIgniter\Config\BaseService;
use App\Core\Services\RoleAccess; // <-- import your custom service

class Services extends BaseService
{
    public static function roleAccess(bool $getShared = true): RoleAccess
    {
        if ($getShared) {
            return static::getSharedInstance('roleAccess');
        }

        return new RoleAccess();
    }

    public static function rbac($getShared = true)
{
    if ($getShared) {
        return static::getSharedInstance('rbac');
    }
    return new \App\Core\Services\Rbac();
}

}