<?php

namespace ZfcUserAcl\Service;

use Zend\Acl\Acl,
    ZfcUserAcl\Model\Role;

class ZfcUserAclService
{
    protected $aclService;
    protected $userService;
    protected $roleMapper;
    protected $serviceManager;

    const TYPE_ALLOW = 'allow';
    const TYPE_DENY = 'deny';

    public function load($e)
    {
        $allRoles = $this->roleMapper->getAllStaticRoles();
        foreach ($allRoles as $role) {
            $this->getAclService()->getAcl()->addRole($role);
        }

        $loader = $this->serviceManager->get('ZfcUserAcl\Service\AclLoaderZendDb');
        $provider = $this->serviceManager->get('ZfcUserAcl\Service\RoleProvider');
        $loader->loadAclByRoleId($this->aclService->getAcl(), $provider->getCurrentRole());

        $resourceResponse = $e->getTarget()->events()->trigger('ZfcUserAcl.loadAclResources', $this);
        $ruleResponse = $e->getTarget()->events()->trigger('ZfcUserAcl.loadAclRules', $this);

        $resources = array();
        foreach ($resourceResponse as $i) {
            $resources = array_merge($resources, $i);
        }

        $rules = array();
        foreach ($ruleResponse as $i) {
            $rules = array_merge($rules, $i);
        }

        $this->loadResources($resources, null);
        $this->loadRules($rules);
    }

    /**
     * Mimics ZfcAcl\Model\Mapper\AclLoaderConfig
     */
    protected function loadResources(array $resources, $parent = null)
    {
        foreach ($resources as $key => $value) {
            if (is_array($value)) {
                $this->getAclService()->getAcl()->addResource($key, $parent);
                $this->loadResources($value, $key);
            } else {
                $this->getAclService()->getAcl()->addResource($key, $parent);
            }
        }
    }
    
    /**
     * Mimics ZfcAcl\Model\Mapper\AclLoaderConfig
     */
    protected function loadRules(array $rules)
    {
        if (isset($rules['allow'])) {
            foreach ($rules['allow'] as $rule) {
                $this->loadRule($rule, 'allow');
            }
        }

        if (isset($rules['deny'])) {
            foreach ($rules['deny'] as $rule) {
                $this->loadRule($rule, 'deny');
            }
        }
    }
    
    /**
     * Mimics ZfcAcl\Model\Mapper\AclLoaderConfig
     */
    protected function loadRule(array $rule, $type) {
        $privileges = null;

        if (count($rule) == 3) {
            // role/resource/privilege defined
            list($roles, $resources, $privileges) = $rule;
        } else if (count($rule) == 2) {
            // role/resource defined
            list($roles, $resources) = $rule;
        } else {
            throw new \InvalidArgumentException("Invalid rule definition: " . print_r($rule, true));
        }

        if($type == static::TYPE_ALLOW) {
            $this->getAclService()->getAcl()->allow($roles, $resources, $privileges);
        } else {
            $this->getAclService()->getAcl()->deny($roles, $resources, $privileges);
        }
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
 
    public function getServiceManager()
    {
        return $this->serviceManager;
    }
 
    public function setServiceManager($serviceManager)
    {
        $this->serviceManager = $serviceManager;
        return $this;
    }
}
