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
        $acl = new Acl();
        $acl->addRole('master');
        $acl->addRole('slave');
        $acl->addRole('bitch');
        return $acl;
    }

    public function getUserRole()
    {
        if (!$this->userService->getAuthService()->hasIdentity()) {
            $role = $this->roleMapper->getDefaultRole();
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
