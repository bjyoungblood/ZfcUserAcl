<?php

namespace ZfcUserAcl\Service;

use Zend\Acl\Acl,
    ZfcUserAcl\Model\Role;

class ZfcUserAclService
{
    protected $aclService;
    protected $userService;
    protected $roleMapper;

    public function loadAcl()
    {
        var_dump('ZfcUserAclService::loadAcl');die();
        $acl = new Acl();
        $acl->addRole('master');
        $acl->addRole('slave');
        return $acl;
    }

    public function loadResource()
    {
        var_dump('ZfcUserAclService::loadResource');die();
    }

    public function getUserRole()
    {
        $role = new Role();
        $role->setRoleId('user-identity');

        return $role;
    }

    public function getAclService()
    {
        return $this->aclService;
    }
 
    public function setAclService($aclService)
    {
        $this->aclService = $aclService;
        return $this;
    }
 
    public function getUserService()
    {
        return $this->userService;
    }
 
    public function setUserService($userService)
    {
        $this->userService = $userService;
        return $this;
    }
 
    public function getRoleMapper()
    {
        return $this->roleMapper;
    }
 
    public function setRoleMapper($roleMapper)
    {
        $this->roleMapper = $roleMapper;
        return $this;
    }
}
