<?php

namespace ZfcUserAcl\Service;

use ZfcAcl\Service\Acl\RoleProvider as RoleProviderInterface;

class RoleProvider implements RoleProviderInterface
{
    protected $zfcUserAclService;

    public function getCurrentRole()
    {
        return $this->getZfcUserAclService()->getUserRole();
    }

    public function getZfcUserAclService()
    {
        return $this->zfcUserAclService;
    }
 
    public function setZfcUserAclService($zfcUserAclService)
    {
        $this->zfcUserAclService = $zfcUserAclService;
        return $this;
    }
}
