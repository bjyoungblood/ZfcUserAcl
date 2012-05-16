<?php

namespace ZfcUserAcl\Service;

use Zend\Acl\Acl;

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
        $acl->addRole('bitch');
        return $acl;
    }

    public function loadResource()
    {
        var_dump('ZfcUserAclService::loadResource');die();
    }

    public function getUserRole()
    {
        if (!$this->userService->getAuthService()->hasIdentity()) {
            $role = $this->roleMapper->getDefaultRole();
        } else {
            $identity = $this->userService->getAuthService()->getIdentity();
            $role = $this->roleMapper->getUserRole($identity->getUserId());
            $role->setBaseName($role->getRoleId());
            $role->setRoleId($role->getRoleId() . '/' . $identity->getUserId());
        }

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
