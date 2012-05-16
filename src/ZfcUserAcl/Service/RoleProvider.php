<?php

namespace ZfcUserAcl\Service;

use ZfcAcl\Service\Acl\RoleProvider as RoleProviderInterface,
    ZfcUserAcl\Model\Role;

class RoleProvider implements RoleProviderInterface
{
    public function getCurrentRole()
    {
        $role = new Role();
        $role->setRoleId('user-identity');
        return $role;
    }
}
