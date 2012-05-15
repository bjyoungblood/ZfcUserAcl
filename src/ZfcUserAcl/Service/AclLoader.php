<?php

namespace ZfcUserAcl\Service;

use ZfcAcl\Model\Mapper\AclLoader as AclLoaderInterface,
    Zend\Acl\Acl;

class AclLoader implements AclLoaderInterface
{
    public function loadAclByRoleId(Acl $acl, $roleId)
    {
        $acl->addRole($roleId);
    }
}
