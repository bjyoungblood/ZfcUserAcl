<?php

namespace ZfcUserAcl\Service;

use ZfcAcl\Model\Mapper\AclLoader as AclLoaderInterface,
    ZfcUserAcl\Model\Role,
    Zend\Acl\Acl;

class AclLoaderZendDb implements AclLoaderInterface
{
    protected $roleMapper;
    protected $userService;

    public function loadAclByRoleId(Acl $acl, $roleId)
    {
        if (!$this->userService->getAuthService()->hasIdentity()) {
            $staticRoles = array($this->roleMapper->getDefaultRole());
        } else {
            $identity = $this->userService->getAuthService()->getIdentity();
            $staticRoles = $this->roleMapper->getUserRoles($identity);
        }

        foreach ($staticRoles as $r) {
            try {
                $acl->addRole($r, $r->getParent());
            } catch (\Exception $e) {
                // role already added
            }
        }

        $acl->addRole($roleId, $staticRoles);
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
 
    /**
     * Get userService.
     *
     * @return userService
     */
    public function getUserService()
    {
        return $this->userService;
    }
 
    /**
     * Set userService.
     *
     * @param $userService the value to be set
     */
    public function setUserService($userService)
    {
        $this->userService = $userService;
        return $this;
    }
}
